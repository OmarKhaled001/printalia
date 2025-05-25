<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Designer;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\DesignerResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DesignerResource\RelationManagers;

class DesignerResource extends Resource
{
    protected static ?string $model = Designer::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationGroup = 'الحسابات';
    protected static ?string $label = 'مصمم';
    protected static ?string $pluralLabel = 'المصممين';
    protected static ?string $slug = 'designers';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make([
                'default' => 1,
                'lg' => 12,
            ])->schema([
                FileUpload::make('profile')
                    ->avatar()
                    ->label('صورة الملف الشخصي')
                    ->directory('designers')
                    ->columnSpan(4),

                Grid::make([
                    'default' => 1,
                    'lg' => 12,
                ])->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->columnSpan(6)
                        ->label('الاسم')
                        ->maxLength(255),

                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->columnSpan(6)
                        ->required()
                        ->label('البريد الإلكتروني')
                        ->unique(ignoreRecord: true),

                    Forms\Components\TextInput::make('phone')
                        ->tel()
                        ->columnSpan(6)
                        ->label('رقم الهاتف')
                        ->maxLength(20),

                    Forms\Components\TextInput::make('national_id')
                        ->columnSpan(6)
                        ->label('الرقم القومي')
                        ->maxLength(50),
                ])->columnSpan(8),

                MarkdownEditor::make('address')
                    ->label('العنوان')
                    ->columnSpan(12)
                    ->maxLength(500),

                Forms\Components\TextInput::make('password')
                    ->password()
                    ->label('كلمة المرور')
                    ->columnSpan(6)
                    ->required(fn($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord)
                    ->confirmed()
                    ->hidden('edit')
                    ->dehydrateStateUsing(fn($state) => \Illuminate\Support\Facades\Hash::make($state))
                    ->maxLength(255),

                Forms\Components\TextInput::make('password_confirmation')
                    ->password()
                    ->label('تأكيد كلمة المرور')
                    ->columnSpan(6)
                    ->hidden('edit')
                    ->required(fn($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord)
                    ->dehydrated(false),

                FileUpload::make('attachments')
                    ->directory('designers')
                    ->multiple()
                    ->label('مرفقات')
                    ->columnSpan(12)
                    ->reorderable(),

                Toggle::make('is_verified')
                    ->label('تم التحقق')
                    ->columnSpan(4),
                Toggle::make('has_active_subscription')
                    ->columnSpan(4)
                    ->label('مشترك'),

                Toggle::make('is_verified')
                    ->columnSpan(4)
                    ->label('مفعل'),
            ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('profile')
                    ->circular()
                    ->label('صورة الملف الشخصي')
                    ->size(40),

                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('البريد الإلكتروني')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('phone')
                    ->label('رقم الهاتف')
                    ->toggleable()
                    ->sortable(),


                Tables\Columns\IconColumn::make('is_verified')
                    ->boolean()
                    ->label('تم التحقق'),

                Tables\Columns\IconColumn::make('has_active_subscription')
                    ->boolean()
                    ->label('مشترك'),

                Tables\Columns\IconColumn::make('is_verified')
                    ->boolean()
                    ->label('مفعل'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->label('تاريخ الإنشاء'),
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
            'index' => Pages\ListDesigners::route('/'),
            'create' => Pages\CreateDesigner::route('/create'),
            'edit' => Pages\EditDesigner::route('/{record}/edit'),
        ];
    }
}
