<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;


    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationGroup = 'المنتجات';
    protected static ?string $label = 'منتج';
    protected static ?string $pluralLabel = 'المنتجات';
    protected static ?string $slug = 'products';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(12)->schema([
                TextInput::make('name')
                    ->label('اسم المنتج')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(6),

                TextInput::make('price')
                    ->label('سعر التصنيع')
                    ->numeric()
                    ->step(0.01)
                    ->suffix('ر.س')
                    ->columnSpan(6),

                Toggle::make('is_double_sided')
                    ->label('طباعة مزدوجة؟')
                    ->live()
                    ->columnSpan(12),



                FileUpload::make('image_front')
                    ->label('صورة أمامية')
                    ->image()
                    ->disk('public')
                    ->directory('products/front')
                    ->columnSpan(6),

                FileUpload::make('image_back')
                    ->label('صورة خلفية')
                    ->image()
                    ->disk('public')
                    ->visible(fn(callable $get) => $get('is_double_sided'))
                    ->directory('products/back')
                    ->columnSpan(6),

                Textarea::make('description')
                    ->label('الوصف')
                    ->maxLength(1000)
                    ->columnSpan(12),
                Toggle::make('is_published')
                    ->label('نشر المنتج؟')
                    ->default(true)
                    ->columnSpan(12),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_front')
                    ->label('الصورة الأمامية')
                    ->circular()
                    ->size(40),

                TextColumn::make('name')
                    ->label('اسم المنتج')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('price')
                    ->label('السعر')
                    ->suffix('ر.س')
                    ->sortable(),

                IconColumn::make('is_double_sided')
                    ->label('مزدوج؟')
                    ->boolean(),

                IconColumn::make('is_published')
                    ->label('منشور؟')
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
