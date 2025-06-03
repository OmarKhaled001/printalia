<?php

namespace App\Filament\Designer\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Enums\StatusTypes;
use Filament\Tables\Table;
use App\Models\Transaction;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\DesignerTransactionResource\Pages;
use App\Filament\Designer\Resources\TransactionResource\Pages\ListTransactions;
use App\Filament\Designer\Resources\TransactionResource\Widgets\TransactionStatsOverview;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel = 'أرباحي';
    protected static ?string $modelLabel = 'حوالة';
    protected static ?string $pluralModelLabel = 'أرباحي';
    protected static ?string $navigationGroup = 'الحساب';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // يمكن إضافة حقول التعديل إذا لزم الأمر
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order.customer.name')
                    ->label('العميل')
                    ->sortable()
                    ->searchable()->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('factory.name')
                    ->label('المصنع')
                    ->color('primary')->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('amount')
                    ->label('المبلغ')
                    ->money('SAR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('type')
                    ->label('النوع')
                    ->badge(),

                Tables\Columns\TextColumn::make('status')
                    ->label('الحالة')
                    ->badge(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ التحويل')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('حالة الحوالة')
                    ->options([
                        '0' => 'قيد الانتظار',
                        '3' => 'منتهي',
                    ]),

                Filter::make('created_at')
                    ->label('فلترة بالتاريخ')
                    ->form([
                        Forms\Components\DatePicker::make('from')
                            ->label('من تاريخ'),
                        Forms\Components\DatePicker::make('to')
                            ->label('إلى تاريخ'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn($query) => $query->whereDate('created_at', '>=', $data['from'])
                            )
                            ->when(
                                $data['to'],
                                fn($query) => $query->whereDate('created_at', '<=', $data['to'])
                            );
                    })
            ]);
        // ->actions([
        //     // Action::make('view_order')
        //     //     ->label('عرض التفاصيل')
        //     //     ->icon('heroicon-o-eye')
        //     //     ->url(fn($record) => route('filament.designer.resources.orders.edit', $record->order))
        //     //     ->openUrlInNewTab(),
        // ])
        // ->defaultSort('created_at', 'desc')
        // ->emptyStateHeading('لا توجد حولات حتى الآن');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('designer_id', Auth::id())
            ->whereIn('status', [StatusTypes::Pending, StatusTypes::Finished]);
    }

    public static function getRelations(): array
    {
        return [
            // يمكن إضافة العلاقات إذا لزم الأمر
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTransactions::route('/'),
        ];
    }

    public static function getHeaderWidgetsColumns(): array
    {
        return [
            \App\Filament\Designer\Resources\TransactionResource\Widgets\TransactionStatsOverview::class,
        ];
    }
}
