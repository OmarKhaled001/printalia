<?php

namespace App\Filament\Resources\DesignerResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;
use Filament\Tables\Actions\Action;
use Filament\Support\Enums\ActionSize;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\BooleanColumn;
use App\Filament\Resources\SubscriptionResource;
use Filament\Resources\RelationManagers\RelationManager;

class SubscriptionsRelationManager extends RelationManager
{
    protected static string $relationship = 'subscriptions';
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $label = 'الاشتراك';

    protected static ?string $pluralLabel = 'الاشتراكات';
    protected static ?string $title = 'الاشتراكات';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\FileUpload::make('receipt')
                ->label('إيصال الدفع')
                ->directory('receipts')
                ->image()
                ->imagePreviewHeight(100)
                ->downloadable(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('plan.name')
                    ->label('الخطة')
                    ->url(fn($record) => SubscriptionResource::getUrl('edit', ['record' => $record]))
                    ->openUrlInNewTab()
                    ->color('primary'),
                TextColumn::make('plan.price')->label('السعر'),

                ImageColumn::make('receipt')
                    ->label('الإيصال')
                    ->disk('public')
                    ->height(50),

                SelectColumn::make('status')
                    ->label('الحالة')
                    ->options([
                        'active' => 'مطابق',
                        'rejected' => 'مرفوض',
                    ])
                    ->sortable(),

                BooleanColumn::make('is_approved')->label('مفعل'),
                TextColumn::make('start_date')->label('تاريخ البداية')->date(),
                TextColumn::make('end_date')->label('تاريخ النهاية')->date(),
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Action::make('download_receipt')
                    ->label('تحميل الإيصال')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn($record) => Storage::disk('public')->url($record->receipt))
                    ->openUrlInNewTab()
                    ->visible(fn($record) => $record->receipt),
                Action::make('activate')
                    ->label('تفعيل')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        DB::transaction(function () use ($record) {
                            $record->subscribable->subscriptions()->update(['is_approved' => false]);
                            $record->update(['is_approved' => true]);
                        });
                    })
                    ->visible(fn($record) => !$record->is_approved),

            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
