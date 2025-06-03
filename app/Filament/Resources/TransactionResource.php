<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Enums\StatusTypes;
use Filament\Tables\Table;
use App\Models\Transaction;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $label = 'حوالة';
    protected static ?string $pluralLabel = 'الحولات';
    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order.id')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('رقم الطلب'),

                Tables\Columns\TextColumn::make('factory.name')
                    ->label('اسم المصنع')
                    ->url(fn($record) => $record->factory
                        ? route('filament.admin.resources.factories.edit', $record->factory)
                        : null)
                    ->openUrlInNewTab()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->color('primary'),

                Tables\Columns\TextColumn::make('designer.name')
                    ->label('اسم المصمم')
                    ->url(fn($record) => $record->designer
                        ? route('filament.admin.resources.designers.edit', $record->designer)
                        : null)
                    ->openUrlInNewTab()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('amount')
                    ->label('المبلغ')
                    ->money('SAR'),

                Tables\Columns\TextColumn::make('type')
                    ->label('النوع')
                    ->badge(),

                Tables\Columns\TextColumn::make('status')
                    ->label('الحالة')
                    ->badge(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('created_at')
                    ->label('تصفية بالتاريخ')
                    ->form([
                        Forms\Components\DatePicker::make('from')->label('من تاريخ'),
                        Forms\Components\DatePicker::make('until')->label('إلى تاريخ'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'], fn($q) => $q->whereDate('created_at', '>=', $data['from']))
                            ->when($data['until'], fn($q) => $q->whereDate('created_at', '<=', $data['until']));
                    }),
            ])
            ->actions([
                Action::make('markAsFinished')
                    ->label('إرسال')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->action(function ($record) {
                        $record->status = StatusTypes::Finished;
                        $record->save();

                        Notification::make()
                            ->title('تم تحديث الحالة إلى "منتهية"')
                            ->success()
                            ->send();

                        Notification::make()
                            ->title('مبارك')
                            ->body("تم تحويل ربحك من الطلب #{$record->order->id} إلى حسابك. الربح: { $record->amount} ريال.")
                            ->success()
                            ->sendToDatabase($record->designer);
                    })
                    ->visible(fn($record): bool => $record->status !== StatusTypes::Finished),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
