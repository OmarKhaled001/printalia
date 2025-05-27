<?php

namespace App\Filament\Designer\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Design;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\View;
use Filament\Forms\Components\Radio;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Designer\Resources\DesignResource\Pages;
use App\Filament\Designer\Resources\DesignResource\RelationManagers;

class DesignResource extends Resource
{
    protected static ?string $model = Design::class;
    protected static ?string $navigationIcon = 'heroicon-o-paint-brush';
    protected static ?string $modelLabel = 'تصميم';
    protected static ?string $pluralModelLabel = 'التصاميم';
    protected static ?string $navigationLabel = 'التصاميم';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Wizard::make([
                    Step::make('اختيار الموكب')->schema([
                        Radio::make('product_id')
                            ->label('اختر المنتج (الموكب)')
                            ->options(
                                \App\Models\Product::all()->mapWithKeys(function ($product) {
                                    return [
                                        $product->id => new HtmlString(
                                            '<div class="flex flex-col items-center gap-2 p-2">' .
                                                '<img src="' . asset('storage/' . $product->image_front) . '" class="w-24 object-contain" style="max-height:150px !important;">' .
                                                '<span>' . $product->name . '</span>' .
                                                '</div>'
                                        )
                                    ];
                                })->toArray()
                            )
                            ->columns(3)
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                $product = \App\Models\Product::find($state);
                                $set('is_double_sided', $product?->is_double_sided ?? false);
                                $set('background_image_front', $product?->image_front ?? '');
                                $set('background_image_back', $product?->image_back ?? '');
                            })
                            ->required()
                            ->inlineLabel(false)
                            ->columnSpanFull(),

                        FileUpload::make('logo_front')
                            ->label('الشعار الامامي')
                            ->image()
                            ->multiple(false)
                            ->columnSpan(1)
                            ->required()
                            ->directory('designs')
                            ->imageEditor()
                            ->imageEditorViewportWidth('800')
                            ->imageEditorViewportHeight('600'),

                        FileUpload::make('logo_back')
                            ->label('الشعار الخلفي')
                            ->image()
                            ->multiple(false)
                            ->required()
                            ->columnSpan(1)
                            ->directory('designs')
                            ->imageEditor()
                            ->imageEditorViewportWidth('800')
                            ->visible(fn($get) => $get('is_double_sided'))
                            ->imageEditorViewportHeight('600'),

                        Hidden::make('background_image_front'),
                        Hidden::make('background_image_back'),
                        Hidden::make('final_design_front'),
                        Hidden::make('final_design_back'),

                    ]),

                    Step::make('التصميم الأمامي')->schema([
                        View::make('components.design-editor-front')
                            ->label('محرر الشعار والخلفية (أمامي)')
                            ->viewData(fn($get) => [
                                'background' => asset('storage/' . $get('background_image_front')),
                                'logo' => $get('logo_front')
                                    ? asset('storage/' . (
                                        is_array($get('logo_front'))
                                        ? ($get('logo_front')['path'] ?? $get('logo_front')['name'] ?? '')
                                        : $get('logo_front')
                                    ))
                                    : '',

                                'targetInputId' => 'final_design_front',
                            ]),
                    ]),


                    Step::make('التصميم الخلفي')->schema([
                        View::make('components.design-editor-back')
                            ->label('محرر الشعار والخلفية (خلفي)')
                            ->viewData(fn($get) => [
                                'background' => asset('storage/' . $get('background_image_back')),
                                'logo' => $get('logo_back')
                                    ? asset('storage/' . (
                                        is_array($get('logo_back'))
                                        ? ($get('logo_back')['path'] ?? $get('logo_back')['name'] ?? '')
                                        : $get('logo_back')
                                    ))
                                    : '',

                                'targetInputId' => 'final_design_back',
                            ]),
                    ])->visible(fn($get) => $get('is_double_sided')),




                    Step::make('تفاصيل التصميم')->schema([
                        Grid::make(2)->schema([
                            TextInput::make('title')
                                ->label('عنوان التصميم')
                                ->required()
                                ->maxLength(255),

                            TextInput::make('sale_price')
                                ->label('سعر البيع')
                                ->required()
                                ->columnSpan(1)
                                ->numeric()
                                ->reactive()
                                ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                    $productPrice = \App\Models\Product::find($get('product_id'))?->price ?? 0;
                                    $set('profit', $state - $productPrice);
                                }),

                            Placeholder::make('price')
                                ->label('سعر التكلفة (المنتج الأصلي)')
                                ->content(
                                    fn(callable $get) =>
                                    number_format(\App\Models\Product::find($get('product_id'))?->price ?? 0, 2) . ' ر.س'
                                )
                                ->columnSpan(1),

                            Placeholder::make('profit')
                                ->label('إجمالي المكسب')
                                ->content(
                                    fn(callable $get) =>
                                    number_format(max(($get('sale_price') ?? 0) - (\App\Models\Product::find($get('product_id'))?->price ?? 0), 0), 2) . ' ر.س'
                                )
                                ->columnSpan(1),
                        ]),

                        MarkdownEditor::make('description')
                            ->label('وصف التصميم')
                            ->columnSpanFull(),

                        Toggle::make('is_published')
                            ->label('نشر التصميم')
                            ->required(),

                        Forms\Components\Hidden::make('designer_id')
                            ->default(Auth::id()),
                    ])->columnSpan(2)



                ])->columnSpanFull()
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('designer_id', Auth::id());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_front')
                    ->label('صورة التصميم')
                    ->size(60),

                Tables\Columns\TextColumn::make('title')
                    ->label('عنوان التصميم')
                    ->searchable(),

                Tables\Columns\TextColumn::make('product.name')
                    ->label('اسم المنتج')
                    ->sortable(),

                Tables\Columns\TextColumn::make('sale_price')
                    ->label('سعر البيع')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('منشور؟')
                    ->boolean(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label(false),
                Tables\Actions\DeleteAction::make()->label(false),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('حذف المحدد'),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDesigns::route('/'),
            'create' => Pages\CreateDesign::route('/create'),
            'edit' => Pages\EditDesign::route('/{record}/edit'),

        ];
    }
}
