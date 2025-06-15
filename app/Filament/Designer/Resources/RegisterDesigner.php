<?php

namespace App\Filament\Designer\Resources;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Exception;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Events\Auth\Registered;
use Filament\Facades\Filament;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Http\Responses\Auth\Contracts\RegistrationResponse;
use Filament\Notifications\Auth\VerifyEmail;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\CanUseDatabaseTransactions;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Pages\SimplePage;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Auth\SessionGuard;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Filament\Forms\Components\Wizard; // Don't forget to import Wizard
use Filament\Forms\Components\FileUpload; // Don't forget to import FileUpload
use App\Models\Designer; // Import your Designer model

/**
 * @property Form $form
 */
class RegisterDesigner extends SimplePage // Renamed for clarity, assuming you'll have a separate Register for default users
{
    use CanUseDatabaseTransactions;
    use InteractsWithFormActions;
    use WithRateLimiting;

    /**
     * @var view-string
     */
    protected static string $view = 'filament-panels::pages.auth.register';

    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    // Make sure to explicitly set the user model to Designer
    protected string $userModel = Designer::class;

    public function mount(): void
    {
        if (Filament::auth()->check()) {
            redirect()->intended(Filament::getUrl());
        }

        $this->callHook('beforeFill');

        if (request()->has('ref')) {
            $referralCode = request()->get('ref');

            $referrer = Designer::where('referral_code', $referralCode)->first();

            if ($referrer) {
                $this->data['referred_by'] = $referrer->id;
            }
        }

        $this->form->fill();

        $this->callHook('afterFill');
    }


    public function register(): ?RegistrationResponse
    {
        try {
            $this->rateLimit(2);
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();

            return null;
        }

        $user = $this->wrapInDatabaseTransaction(function () {
            $this->callHook('beforeValidate');

            $data = $this->form->getState();

            $this->callHook('afterValidate');

            $data = $this->mutateFormDataBeforeRegister($data);

            $this->callHook('beforeRegister');

            $user = $this->handleRegistration($data);

            // This line is crucial for file uploads, ensure it's here
            $this->form->model($user)->saveRelationships();

            $this->callHook('afterRegister');

            return $user;
        });

        // Assuming designers also need email verification and login
        event(new Registered($user));

        $this->sendEmailVerificationNotification($user);

        Filament::auth()->login($user);

        session()->regenerate();

        return app(RegistrationResponse::class);
    }

    protected function getRateLimitedNotification(TooManyRequestsException $exception): ?Notification
    {
        return Notification::make()
            ->title(__('filament-panels::pages/auth/register.notifications.throttled.title', [
                'seconds' => $exception->secondsUntilAvailable,
                'minutes' => $exception->minutesUntilAvailable,
            ]))
            ->body(array_key_exists('body', __('filament-panels::pages/auth/register.notifications.throttled') ?: []) ? __('filament-panels::pages/auth/register.notifications.throttled.body', [
                'seconds' => $exception->secondsUntilAvailable,
                'minutes' => $exception->minutesUntilAvailable,
            ]) : null)
            ->danger();
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function handleRegistration(array $data): Model
    {
        // Hash the password before creating the user
        return $this->getUserModel()::create($data);
    }

    protected function sendEmailVerificationNotification(Model $user): void
    {
        if (! $user instanceof MustVerifyEmail) {
            return;
        }

        if ($user->hasVerifiedEmail()) {
            return;
        }

        if (! method_exists($user, 'notify')) {
            $userClass = $user::class;

            throw new Exception("Model [{$userClass}] does not have a [notify()] method.");
        }

        $notification = app(VerifyEmail::class);
        $notification->url = Filament::getVerifyEmailUrl($user);

        $user->notify($notification);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('البيانات الأساسية')->schema([
                        TextInput::make('name')
                            ->label('الاسم الكامل')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('البريد الإلكتروني')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique('designers', 'email'), // Ensure this is correct for your 'designers' table and 'email' column
                        TextInput::make('phone')
                            ->label('رقم الجوال')
                            ->required()
                            ->maxLength(255)
                            ->unique('designers', 'phone'), // Ensure this is correct for your 'designers' table and 'phone' column
                        TextInput::make('password')
                            ->label('كلمة المرور')
                            ->password()
                            ->required()
                            ->confirmed()
                            ->maxLength(50)
                            ->dehydrated() // مهم لتخزين القيمة
                            ->mutateDehydratedStateUsing(fn($state) => bcrypt($state)),

                        TextInput::make('password_confirmation')
                            ->label('تأكيد كلمة المرور')
                            ->password()
                            ->required()
                            ->maxLength(50)
                            ->dehydrated(false), // لا تحفظ قيمة التأكيد في DB
                    ])->columns(1), // You can organize fields into columns within a step
                    Wizard\Step::make('التوثيق')->schema([
                        FileUpload::make('profile')
                            ->label('صورة الشخصية')
                            ->directory('designer-profile') // Optional: specifies a directory within storage
                            ->avatar()
                            ->required()
                            ->image(), // Optional: restricts to image files
                        TextInput::make('national_id')
                            ->label('الهوية الوطنية')
                            ->maxLength(255)
                            ->unique('designers', 'national_id'), // Ensure this is correct
                        TextInput::make('address') // Changed to TextInput as you provided Textarea, but TextInput is more common for single-line addresses. Use Textarea if multi-line is needed.
                            ->label('العنوان')
                            ->maxLength(255),
                        FileUpload::make('attachments')
                            ->label('صورة البطاقة')
                            ->required()
                            ->directory('designer-attachments') // Optional: specifies a directory within storage
                            ->multiple() // Optional: allows multiple files if needed
                            ->image(), // Optional: restricts to image files
                    ])->columns(1),
                ])
            ])
            ->statePath('data');
    }

    public function loginAction(): Action
    {
        return Action::make('login')
            ->link()
            ->label(__('filament-panels::pages/auth/register.actions.login.label'))
            ->url(filament()->getLoginUrl());
    }

    protected function getUserModel(): string
    {
        // Since we explicitly set $userModel, this method will now return App\Models\Designer::class
        return $this->userModel;
    }

    public function getTitle(): string | Htmlable
    {
        return __('filament-panels::pages/auth/register.title');
    }

    public function getHeading(): string | Htmlable
    {
        return __('filament-panels::pages/auth/register.heading');
    }

    /**
     * @return array<Action | ActionGroup>
     */
    protected function getFormActions(): array
    {
        return [
            $this->getRegisterFormAction(),
        ];
    }

    public function getRegisterFormAction(): Action
    {
        return Action::make('register')
            ->label(__('filament-panels::pages/auth/register.form.actions.register.label'))
            ->submit('register');
    }

    protected function hasFullWidthFormActions(): bool
    {
        return true;
    }



    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeRegister(array $data): array
    {
        // No specific mutation needed here, as password hashing is done in handleRegistration
        // and other fields map directly.
        $data['referred_by'] = $this->data['referred_by'] ?? null;

        return $data;
    }
}
