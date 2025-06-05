<?php

namespace App\Filament\Pages;

use Filament\Forms\Form;
use Filament\Pages\Page;
use App\Models\BankAccount;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Group;
use Illuminate\Support\Facades\Cache;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;

class Setting extends Page implements HasForms
{

    use InteractsWithForms;


    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static ?int $navigationSort = 10;
    protected static string $view = 'filament.pages.setting';

    public static function getNavigationLabel(): string
    {
        return 'الإعدادات ';
    }

    /**
     * @return string|null
     */
    public function getTitle(): string
    {
        return 'الإعدادات ';
    }

    public $bank_accounts;
    public $logo;
    public $icon;
    public $site_title;
    public $site_keywords;
    public $site_description;
    public $bank_code;
    public $present_earn;
    public $hero_section_title;
    public $hero_section_description;
    public $hero_section_is_visible;
    public $hero_section_image;
    public $about_section_title;
    public $about_section_description;
    public $about_section_is_visible;
    public $about_section_image;
    public $vision_section_title;
    public $vision_section_description;
    public $vision_section_is_visible;
    public $vision_section_image;
    public $additional_1_section_title;
    public $additional_1_section_description;
    public $additional_1_section_is_visible;
    public $additional_1_section_image;
    public $additional_2_section_title;
    public $additional_2_section_description;
    public $additional_2_section_is_visible;
    public $additional_2_section_image;
    public $contact_phone;
    public $contact_email;
    public $contact_zip_code;
    public $contact_address;
    public $facebook_link;
    public $instagram_link;

    public function mount()
    {

        $bankAccounts = \App\Models\BankAccount::all(['name', 'code'])->map(function ($account) {
            return [
                'name' => $account->name,
                'code' => $account->code,
            ];
        })->toArray();

        $this->form->fill([
            'logo' => \App\Models\Setting::where('key', 'logo')->value('value'),
            'icon' => \App\Models\Setting::where('key', 'icon')->value('value'),
            'site_title' => \App\Models\Setting::where('key', 'site_title')->value('value'),
            'site_keywords' => \App\Models\Setting::where('key', 'site_keywords')->value('value'),
            'site_description' => \App\Models\Setting::where('key', 'site_description')->value('value'),
            'bank_code' => \App\Models\Setting::where('key', 'bank_code')->value('value'),
            'present_earn' => \App\Models\Setting::where('key', 'present_earn')->value('value'),
            'hero_section_title' => \App\Models\Setting::where('key', 'hero_section_title')->value('value'),
            'hero_section_description' => \App\Models\Setting::where('key', 'hero_section_description')->value('value'),
            'hero_section_is_visible' => \App\Models\Setting::where('key', 'hero_section_is_visible')->value('value'),
            'hero_section_image' => \App\Models\Setting::where('key', 'hero_section_image')->value('value'),
            'about_section_title' => \App\Models\Setting::where('key', 'about_section_title')->value('value'),
            'about_section_description' => \App\Models\Setting::where('key', 'about_section_description')->value('value'),
            'about_section_image' => \App\Models\Setting::where('key', 'about_section_image')->value('value'),
            'about_section_is_visible' => \App\Models\Setting::where('key', 'about_section_is_visible')->value('value'),
            'vision_section_title' => \App\Models\Setting::where('key', 'vision_section_title')->value('value'),
            'vision_section_description' => \App\Models\Setting::where('key', 'vision_section_description')->value('value'),
            'vision_section_is_visible' => \App\Models\Setting::where('key', 'vision_section_is_visible')->value('value'),
            'vision_section_image' => \App\Models\Setting::where('key', 'vision_section_image')->value('value'),
            'additional_1_section_title' => \App\Models\Setting::where('key', 'additional_1_section_title')->value('value'),
            'additional_1_section_description' => \App\Models\Setting::where('key', 'additional_1_section_description')->value('value'),
            'additional_1_section_is_visible' => \App\Models\Setting::where('key', 'additional_1_section_is_visible')->value('value'),
            'additional_1_section_image' => \App\Models\Setting::where('key', 'additional_1_section_image')->value('value'),
            'additional_2_section_title' => \App\Models\Setting::where('key', 'additional_2_section_title')->value('value'),
            'additional_2_section_description' => \App\Models\Setting::where('key', 'additional_2_section_description')->value('value'),
            'additional_2_section_is_visible' => \App\Models\Setting::where('key', 'additional_2_section_is_visible')->value('value'),
            'additional_2_section_image' => \App\Models\Setting::where('key', 'additional_2_section_image')->value('value'),
            'contact_phone' => \App\Models\Setting::where('key', 'contact_phone')->value('value'),
            'contact_email' => \App\Models\Setting::where('key', 'contact_email')->value('value'),
            'contact_zip_code' => \App\Models\Setting::where('key', 'contact_zip_code')->value('value'),
            'contact_address' => \App\Models\Setting::where('key', 'contact_address')->value('value'),
            'facebook_link' => \App\Models\Setting::where('key', 'facebook_link')->value('value'),
            'instagram_link' => \App\Models\Setting::where('key', 'instagram_link')->value('value'),
            'bank_accounts' => $bankAccounts,

        ]);
    }



    public function form(Form $form): Form
    {
        return $form->schema([


            Tabs::make('settings_tabs')
                ->tabs([
                    Tab::make('إعدادات الموقع')
                        ->icon('heroicon-o-globe-alt')
                        ->schema([


                            TextInput::make('site_title')
                                ->label('عنوان الموقع')
                                ->placeholder('مثال: Printalia - منصة الربح من التصميم والطباعة')
                                ->required(),

                            TextInput::make('site_keywords')
                                ->label('الكلمات المفتاحية (SEO Keywords)')
                                ->placeholder('مثال: تصميم موك أب، طباعة، ربح من التصميم، منصة مصممين'),

                            Textarea::make('site_description')
                                ->label('وصف الموقع (Meta Description)')
                                ->placeholder('Printalia هي منصة تربط المصممين بمصانع الطباعة في اليمن. صمّم، سوّق، واربح بكل سهولة.')
                                ->rows(4)
                                ->columnSpanFull()
                                ->required(),

                            FileUpload::make('logo')
                                ->label('الشعار')
                                ->imageEditor()
                                ->image()
                                ->directory('settings'),

                            FileUpload::make('icon')
                                ->label('الشعار المُصغر')
                                ->imageEditor()
                                ->image()
                                ->directory('settings'),

                        ])->columns(2),

                    Tab::make('نظام التربح')
                        ->icon('heroicon-o-currency-dollar')
                        ->schema([
                            Repeater::make('bank_accounts')
                                ->label('الحسابات البنكية')
                                ->schema([
                                    TextInput::make('name')
                                        ->label('اسم الحساب')
                                        ->required(),

                                    TextInput::make('code')
                                        ->label('كود الحساب')
                                        ->required(),
                                ])
                                ->columns(2)
                                ->minItems(1) // 👈 هذا هو السطر الذي يفرض وجود عنصر واحد على الأقل
                                ->itemLabel(fn(array $state): ?string => $state['name'] ?? null),

                            TextInput::make('present_earn')
                                ->label('نسبة أرباح المصمم')
                                ->placeholder('مثال: 30')
                                ->numeric()
                                ->minValue(0)
                                ->maxValue(100)
                                ->suffix('%')
                                ->required()
                                ->rules([
                                    'numeric',
                                    'min:0',
                                    'max:100'
                                ])
                                ->validationMessages([
                                    'numeric' => 'يجب أن تكون القيمة رقمية',
                                    'min' => 'لا يمكن أن تكون النسبة أقل من 0%',
                                    'max' => 'لا يمكن أن تكون النسبة أكثر من 100%'
                                ]),
                        ])->columns(2),

                    Tab::make('الترحيب')
                        ->icon('heroicon-o-photo')
                        ->schema([

                            Group::make()->schema([
                                TextInput::make('hero_section_title')->label('العنوان'),
                                Textarea::make('hero_section_description')->label('الوصف'),
                            ]),
                            FileUpload::make('hero_section_image')->label('الصورة')->directory('settings'),
                            Toggle::make('hero_section_is_visible')->label('فعال ؟')->columns(2),

                        ])->columns(2),

                    Tab::make('من نحن')
                        ->icon('heroicon-o-user-group')
                        ->schema([
                            Group::make()->schema([
                                TextInput::make('about_section_title')->label('العنوان'),
                                Textarea::make('about_section_description')->label('الوصف'),
                            ]),

                            FileUpload::make('about_section_image')->label('الصورة')->directory('settings'),
                            Toggle::make('about_section_is_visible')->label('فعال ؟')->columns(2),

                        ])->columns(2),

                    Tab::make('رؤيتنا')
                        ->icon('heroicon-o-eye')
                        ->schema([
                            Group::make()->schema([
                                TextInput::make('vision_section_title')->label('العنوان'),
                                Textarea::make('vision_section_description')->label('الوصف'),
                            ]),

                            FileUpload::make('vision_section_image')->label('الصورة')->directory('settings'),
                            Toggle::make('vision_section_is_visible')->label('فعال ؟')->columns(2),

                        ])->columns(2),
                    Tab::make('إضافي 1')
                        ->icon('heroicon-o-folder-plus')
                        ->schema([
                            Group::make()->schema([
                                TextInput::make('additional_1_section_title')->label('العنوان'),
                                Textarea::make('additional_1_section_description')->label('الوصف'),
                            ]),

                            FileUpload::make('additional_1_section_image')->label('الصورة')->directory('settings'),
                            Toggle::make('additional_1_section_is_visible')->label('فعال ؟')->columns(2),

                        ])->columns(2),

                    Tab::make('إضافي 2')
                        ->icon('heroicon-o-folder-plus')
                        ->schema([
                            Group::make()->schema([
                                TextInput::make('additional_2_section_title')->label('العنوان'),
                                Textarea::make('additional_2_section_description')->label('الوصف'),
                            ]),

                            FileUpload::make('additional_2_section_image')->label('الصورة')->directory('settings'),
                            Toggle::make('additional_2_section_is_visible')->label('فعال ؟')->columns(2),

                        ])->columns(2),

                    Tab::make('التواصل')
                        ->icon('heroicon-o-phone')
                        ->schema([
                            TextInput::make('contact_phone')->label('رقم الهاتف'),
                            TextInput::make('contact_email')->label('البريد الالكتروني')->email(),
                            Textarea::make('contact_address')->label('العنوان'),
                            TextInput::make('contact_zip_code')->label('الرمز البريدي'),
                            TextInput::make('facebook_link')->label('رابط الفيس بوك')->url(),
                            TextInput::make('instagram_link')->label('رابط الانستجرام')->url(),
                        ])->columns(2),
                ])
        ]);
    }

    public function submit()
    {
        $data = $this->form->getState();

        if (isset($data['bank_accounts'])) {
            BankAccount::truncate();

            foreach ($data['bank_accounts'] as $account) {
                BankAccount::create([
                    'name' => $account['name'],
                    'code' => $account['code']
                ]);
            }

            unset($data['bank_accounts']);
        }
        foreach ($data as $key => $value) {
            \App\Models\Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? '']
            );
        }

        Cache::forget('g_setting');

        Notification::make()
            ->success()
            ->title('تم تحديث الإعدادات بنجاح')
            ->body('جاري تحديث إعدادات الموقع في الخلفية.')
            ->send();
    }
}
