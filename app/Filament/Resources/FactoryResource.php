<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Factory;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;

class FactoryResource extends Resource
{
    protected static ?string $model = Factory::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?string $navigationGroup = 'الحسابات';
    protected static ?string $label = 'مصنع';
    protected static ?string $pluralLabel = 'المصانع';
    protected static ?string $slug = 'factories';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make([
                'default' => 1,
                'lg' => 12,
            ])->schema([
                FileUpload::make('logo')
                    ->directory('factories')
                    ->label('شعار المصنع')
                    ->columnSpan(4),

                Grid::make([
                    'default' => 1,
                    'lg' => 12,
                ])->schema([
                    TextInput::make('name')
                        ->label('اسم المصنع')
                        ->required()
                        ->columnSpan(6)
                        ->maxLength(255),

                    TextInput::make('email')
                        ->label('البريد الإلكتروني')
                        ->email()
                        ->columnSpan(6)

                        ->required()
                        ->unique(ignoreRecord: true),

                    TextInput::make('phone')
                        ->label('رقم الهاتف')
                        ->tel()
                        ->required()

                        ->columnSpan(6)
                        ->maxLength(20),


                    TextInput::make('national_id')
                        ->label('الرقم القومي')
                        ->columnSpan(6)
                        ->maxLength(50),
                    TextInput::make('password')
                        ->label('كلمة المرور')
                        ->columnSpan(6)
                        ->confirmed()
                        ->required()

                        ->password()
                        ->maxLength(50),

                    TextInput::make('password_confirmation')
                        ->label('تأكيد كلمة المرور')
                        ->password()
                        ->columnSpan(6)
                        ->required()

                        ->maxLength(20),
                ])->columnSpan(8),

                MarkdownEditor::make('address')
                    ->label('العنوان')
                    ->columnSpan(12)
                    ->maxLength(500),



                FileUpload::make('attachments')
                    ->directory('factories')
                    ->label('المرفقات')
                    ->multiple()
                    ->columnSpan(12)
                    ->reorderable(),

                Toggle::make('is_verified')
                    ->label('تم التحقق')
                    ->columnSpan(12),
            ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->label('الشعار')
                    ->circular()
                    ->size(40),

                TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('البريد الإلكتروني')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('phone')
                    ->label('رقم الهاتف')
                    ->toggleable()
                    ->sortable(),

                IconColumn::make('is_verified')
                    ->label('تم التحقق')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label(false),
                Tables\Actions\EditAction::make()->label(false),
                Tables\Actions\DeleteAction::make()->label(false),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('حذف جماعي'),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\FactoryResource\Pages\ListFactories::route('/'),
            'create' => \App\Filament\Resources\FactoryResource\Pages\CreateFactory::route('/create'),
            'edit' => \App\Filament\Resources\FactoryResource\Pages\EditFactory::route('/{record}/edit'),
        ];
    }
}
