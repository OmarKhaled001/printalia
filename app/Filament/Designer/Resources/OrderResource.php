<?php

namespace App\Filament\Designer\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use App\Models\Design;
use App\Models\Product;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\FactoryOrder;
use Filament\Resources\Resource;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Radio;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Designer\Resources\OrderResource\Pages;
use App\Filament\Designer\Resources\OrderResource\RelationManagers;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'الطلبات';
    protected static ?string $modelLabel = 'طلب';
    protected static ?string $pluralModelLabel = 'الطلبات';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([


                        Radio::make('design_id')
                            ->label('اختر التصميم')
                            ->options(
                                Design::query()
                                    ->whereNotNull('image_front') // Ignore designs without a front image
                                    ->select('id', 'title', 'image_front')
                                    ->get()
                                    ->mapWithKeys(function ($design) {
                                        return [
                                            $design->id => new HtmlString(
                                                '<div class="flex flex-col items-center gap-2 p-2 rounded-md hover:border-primary-500 cursor-pointer">' .
                                                    // Adjusted image size: w-20 h-24 (approx 80px x 96px) for readability
                                                    '<img src="' . asset('storage/app/public/' . $design->image_front) . '" class="w-20 h-24 object-contain" alt="' . e($design->title) . '">' .
                                                    '<span>' . e($design->title) . '</span>' .
                                                    '</div>'
                                            )
                                        ];
                                    })->toArray()
                            )
                            ->columns(4) // Changed to 4 columns
                            ->live()
                            ->required()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $design = \App\Models\Design::find($state);
                                if ($design) {
                                    $set('price', $design->sale_price);
                                    $set('total', $design->sale_price * intval($get('quantity') ?? 0));
                                } else {
                                    $set('price', 0);
                                    $set('total', 0);
                                }
                            })
                            ->inlineLabel(false)
                            ->columnSpanFull(),

                        Forms\Components\Select::make('customer_id')
                            ->label('العميل')
                            ->relationship('customer', 'name')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Hidden::make('designer_id')->default(Auth::user()->id),
                                Forms\Components\TextInput::make('name')->label('الاسم')->required(),
                                Forms\Components\Textarea::make('address')->label('العنوان')->required(),
                                Forms\Components\TextInput::make('phone')->label('رقم الهاتف')->required(),
                            ])
                            ->required(),
                        Hidden::make('designer_id')->default(Auth::user()->id),




                        Forms\Components\TextInput::make('quantity')
                            ->label('الكمية')
                            ->numeric()
                            ->default(1)
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $set('total', floatval($get('price')) * intval($state));
                            }),
                        Select::make('size')
                            ->label('المقاس')
                            ->options([
                                'XS' => 'XS',
                                'S' => 'S',
                                'M' => 'M',
                                'L' => 'L',
                                'XL' => 'XL',
                                'XXL' => 'XXL',
                                'XXXL' => 'XXXL',
                            ])
                            ->native(false)
                            ->visible(function (Get $get) {
                                $design = \App\Models\Design::find($get('design_id'));
                                return $design && $design->product && $design->product->has_sizes;
                            })
                            ->required(function (Get $get) {
                                $design = \App\Models\Design::find($get('design_id'));
                                return $design && $design->product && $design->product->has_sizes;
                            })
                            ->columnSpan([
                                'md' => 2,
                            ])
                            ->reactive(),

                        Forms\Components\Placeholder::make('price_display')
                            ->label('السعر')
                            ->content(fn(callable $get) => number_format($get('price') ?? 0, 2) . ' ر.س'),

                        Forms\Components\Placeholder::make('total_display')
                            ->label('الإجمالي')
                            ->content(fn(callable $get) => number_format($get('total') ?? 0, 2) . ' ر.س'),
                        Placeholder::make('shipping_notice')
                            ->content(new HtmlString('🔔 <strong >تنبيه قبل إنشاء الطلب:</strong><br>
                            سعر المنتج لا يشمل التوصيل.<br>
                            سعر التوصيل داخل صنعاء في الأماكن القريبة من أمانة العاصمة: <strong>1000 ريال يمني</strong>.<br>
                            وفي الأماكن البعيدة في صنعاء: <strong>1500 ريال يمني</strong>.<br>
                            وبالنسبة لخارج صنعاء: <a href="' . route('privacy-policy') . '" style="color: #ff6666; text-decoration: underline;"><strong>اضغط هنا</strong></a>.<br><br>'))
                            ->label('')
                            ->disableLabel()
                            ->columnSpanFull(),
                        Forms\Components\Hidden::make('price'),
                        Forms\Components\Hidden::make('total'),
                    ]),
            ]);
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('designer_id', Auth::user('designer')->id);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('رقم الطلب')->sortable(),
                TextColumn::make('design.title')->label('التصميم'),
                TextColumn::make('quantity')->label('الكمية'),
                TextColumn::make('price')->label('السعر'),
                TextColumn::make('total')->label('الإجمالي'),
                TextColumn::make('currentFactoryOrder.factory.name')->label('المصنع الحالي'),
                TextColumn::make('currentFactoryOrder.status')->label('حالة الطلب')->badge()
                    ->color(fn($record) => $record->currentFactoryOrder?->status?->getColor())
                    ->formatStateUsing(fn($record) => $record->currentFactoryOrder?->status?->getLabel()),

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            // علاقات مستقبلية إذا أردت
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
