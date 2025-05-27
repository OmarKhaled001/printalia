<?php

namespace App\Filament\Designer\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use App\Models\Design;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\FactoryOrder;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
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
                        Forms\Components\Select::make('customer_id')
                            ->label('العميل')
                            ->relationship('customer', 'name')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Hidden::make('designer_id')->default(Auth::user()->id),
                                Forms\Components\TextInput::make('name')->label('الاسم')->required(),
                                Forms\Components\TextInput::make('phone')->label('رقم الهاتف')->required(),
                            ])
                            ->required(),


                        Forms\Components\Select::make('design_id')
                            ->label('التصميم')
                            ->relationship('design', 'title')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $design = \App\Models\Design::find($state);
                                if ($design) {
                                    $set('price', $design->sale_price);
                                    $set('total', $design->sale_price * intval($get('quantity') ?? 0));
                                } else {
                                    $set('price', 0);
                                    $set('total', 0);
                                }
                            }),

                        Forms\Components\TextInput::make('quantity')
                            ->label('الكمية')
                            ->numeric()
                            ->default(1)
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $set('total', floatval($get('price')) * intval($state));
                            }),

                        Forms\Components\Placeholder::make('price_display')
                            ->label('السعر')
                            ->content(fn(callable $get) => number_format($get('price') ?? 0, 2) . ' ج.م'),

                        Forms\Components\Placeholder::make('total_display')
                            ->label('الإجمالي')
                            ->content(fn(callable $get) => number_format($get('total') ?? 0, 2) . ' ج.م'),

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
