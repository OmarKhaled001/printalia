<?php

namespace App\Filament\Designer\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use App\Models\Design;
use App\Models\Product;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\FactoryOrder;
use Filament\Resources\Resource;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Radio;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
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
                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make('معلومات الطلب الأساسية')
                        ->schema([
                            Forms\Components\Select::make('customer_id')
                                ->label('العميل')
                                ->relationship('customer', 'name')
                                ->searchable()
                                ->preload()
                                ->createOptionForm([
                                    Forms\Components\TextInput::make('name')->label('الاسم')->required(),
                                    Forms\Components\Textarea::make('address')->label('العنوان')->required(),
                                    Forms\Components\TextInput::make('phone')->label('رقم الهاتف')->required(),
                                ])
                                ->required(),
                            Hidden::make('designer_id')->default(Auth::id()),
                        ]),

                    Forms\Components\Wizard\Step::make('المنتجات')
                        ->schema([
                            Placeholder::make('products_label')
                                ->label('أضف المنتجات إلى الطلب'),

                            Repeater::make('products')
                                ->label('المنتجات')
                                ->relationship()
                                ->schema([
                                    Select::make('product_id')
                                        ->label('المنتج')
                                        ->options(Product::query()->pluck('name', 'id'))
                                        ->searchable()
                                        ->required()
                                        ->reactive()
                                        ->afterStateUpdated(function (Set $set, $state) {
                                            $product = Product::find($state);
                                            if ($product) {
                                                $set('price', $product->price);
                                            }
                                        })
                                        ->columnSpan([
                                            'md' => 3,
                                        ]),

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
                                        ->visible(fn(Get $get): bool => !!Product::find($get('product_id'))?->has_sizes)
                                        ->required(fn(Get $get): bool => !!Product::find($get('product_id'))?->has_sizes)
                                        ->columnSpan([
                                            'md' => 2,
                                        ]),

                                    TextInput::make('quantity')
                                        ->label('الكمية')
                                        ->numeric()
                                        ->required()
                                        ->default(1)
                                        ->reactive()
                                        ->columnSpan([
                                            'md' => 1,
                                        ]),

                                    TextInput::make('price')
                                        ->label('السعر')
                                        ->numeric()
                                        ->required()
                                        ->disabled()
                                        ->dehydrated()
                                        ->columnSpan([
                                            'md' => 2,
                                        ]),
                                ])
                                ->columns(8)
                                ->live()
                                // --- START OF THE FIX ---
                                // Changed self:: to the explicit class name OrderResource::
                                // This is a more robust way to call a static method from a closure.
                                ->afterStateUpdated(function (Get $get, Set $set) {
                                    OrderResource::updateTotals($get, $set);
                                })
                                ->deleteAction(
                                    fn(Forms\Components\Actions\Action $action) => $action->after(fn(Get $get, Set $set) => OrderResource::updateTotals($get, $set)),
                                ),
                            // --- END OF THE FIX ---
                        ]),
                    Forms\Components\Wizard\Step::make('المراجعة والدفع')
                        ->schema([
                            Placeholder::make('total')
                                ->label('الإجمالي النهائي للطلب')
                                ->content(function (Get $get): string {
                                    return number_format($get('total') ?? 0, 2) . ' ر.س';
                                }),
                        ])
                ])->columnSpanFull(),

                Hidden::make('total')->default(0),
            ]);
    }

    public static function updateTotals(Get $get, Set $set): void
    {
        $total = 0;
        $selectedProducts = $get('products');

        if (is_array($selectedProducts)) {
            foreach ($selectedProducts as $item) {
                if (!empty($item['price']) && !empty($item['quantity'])) {
                    $total += $item['price'] * $item['quantity'];
                }
            }
        }

        $set('total', $total);
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
                TextColumn::make('customer.name')->label('اسم العميل')->searchable(),
                TextColumn::make('products_count')->counts('products')->label('عدد المنتجات'),
                TextColumn::make('total')->label('الإجمالي')->money('SAR'),
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
