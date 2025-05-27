<?php

namespace App\Filament\Pages;

use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
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

    public $logo;
    public $dark_logo;
    public $hero_img;

    public function mount()
    {
        $this->form->fill([
            'logo' => \App\Models\Setting::where('key', 'logo')->value('value'),
        ]);
    }


    public function form(Form $form): Form
    {
        return $form->schema([
            Section::make()
                ->heading('الشعار')
                ->schema([
                    FileUpload::make('logo')
                        ->label('الشعار')
                        ->imageEditor()
                        ->image()
                        ->directory('settings'),

                    FileUpload::make('hero_img')
                        ->label('الشعار المٌصغر')
                        ->imageEditor()
                        ->image()
                        ->directory('settings'),
                ])
                ->columns(2),

            Section::make()
                ->heading('قسم الترحيب')
                ->schema([
                    Group::make()->schema([

                        TextInput::make('hero_section_title')
                            ->label('العنوان'),
                        Textarea::make('hero_section_description')
                            ->label('الوصف'),
                    ]),
                    FileUpload::make('hero_section_image')
                        ->label('المجسم')
                        ->directory('settings'),

                ])
                ->columns(2),


            Section::make()
                ->heading(__('Contact Us Section'))
                ->schema([
                    TextInput::make('contact_section_title')
                        ->label(__('Section Title')),
                    Textarea::make('contact_section_description')
                        ->label(__('Section Description')),
                ])
                ->columns(2),
            Section::make()
                ->heading(__('Footer'))
                ->schema([
                    TextInput::make('contact_phone')
                        ->label(__('Contact Phone'))
                        ->required(),

                    TextInput::make('contact_email')
                        ->label(__('Contact Email'))
                        ->email()
                        ->required(),

                    Textarea::make('contact_address')
                        ->label(__('Contact Address'))
                        ->required(),

                    TextInput::make('contact_zip_code')
                        ->label(__('Contact Zip Code'))
                        ->required(),
                    TextInput::make('facebook_link')
                        ->label('Facebook Link')
                        ->url(),
                    TextInput::make('insta_link')
                        ->label('Instagram Link')
                        ->url(),
                    TextInput::make('twitter_link')
                        ->label('Twitter Link')
                        ->url(),
                ])
                ->columns(2),
        ]);
    }
}
