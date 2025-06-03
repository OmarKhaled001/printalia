<?php

namespace App\Filament\Factory\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Enums\StatusTypes;
use Filament\Tables\Table;
use App\Models\FactoryOrder;
use Filament\Resources\Resource;
use App\Enums\FactoryOrderStatus;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Factory\Widgets\FactoryOrderStats;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Factory\Resources\FactoryOrderResource\Pages;
use App\Filament\Factory\Resources\FactoryOrderResource\RelationManagers;


class FactoryOrderResource extends Resource
{
    protected static ?string $model = FactoryOrder::class;

    protected static ?string $navigationLabel = 'الطلبات الواردة';
    protected static ?string $navigationIcon = 'heroicon-o-inbox';
    protected static ?string $modelLabel = 'الطلب';
    protected static ?string $pluralModelLabel = 'الطلبات الواردة';

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(FactoryOrder::query()->where('factory_id', auth('factory')->id()))
            ->columns([
                Tables\Columns\TextColumn::make('order.id')->label('رقم الطلب')->searchable(),
                Tables\Columns\TextColumn::make('order.design.title')->label('التصميم')->searchable(),
                Tables\Columns\TextColumn::make('status')->label('الحالة')->badge(),
                Tables\Columns\TextColumn::make('created_at')->label('تاريخ الطلب')->dateTime(),
            ])->filters([
                SelectFilter::make('status')
                    ->label('حالة الطلب')
                    ->options(StatusTypes::class)
                    ->native(false),
            ])
            ->actions([
                Action::make('accept')
                    ->label('قبول')
                    ->visible(fn(FactoryOrder $record) => $record->status === StatusTypes::Pending)
                    ->action(function (FactoryOrder $record) {
                        $record->update(['status' => StatusTypes::Accepted]);
                        $record->order->update(['factory_id' => $record->factory_id]);
                    })
                    ->color('success'),

                Action::make('reject')
                    ->label('رفض')
                    ->visible(fn(FactoryOrder $record) => $record->status === StatusTypes::Pending)
                    ->requiresConfirmation()
                    ->action(function (FactoryOrder $record) {
                        $record->update(['status' => StatusTypes::Rejected]);
                    })
                    ->color('danger'),
                Tables\Actions\ViewAction::make()
                    ->label('عرض الطلب')
                    ->icon('heroicon-o-document-text'),
            ]);
    }

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFactoryOrders::route('/'),
            'view' => Pages\ViewFactoryOrder::route('/{record}'),
        ];
    }


    public static function getWidgets(): array
    {
        return [
            FactoryOrderStats::class,
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('factory_id', auth('factory')->id())->where('status', StatusTypes::Pending)->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'primary';
    }
}
