<?php

namespace App\Filament\Factory\Resources\FactoryOrderResource\Pages;

use App\Enums\StatusTypes;
use App\Models\FactoryOrder;
use Filament\Infolists\Infolist;
use Filament\Pages\Actions\Action;
use Filament\Infolists\Components\Split;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use App\Filament\Factory\Resources\FactoryOrderResource;

class ViewFactoryOrder extends ViewRecord
{
    protected static string $resource = FactoryOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('accept')
                ->label('قبول')
                ->visible(
                    fn(FactoryOrder $record): bool =>
                    $record->status === StatusTypes::Pending
                )
                ->action(function (FactoryOrder $record) {
                    $record->update([
                        'status' => StatusTypes::Accepted
                    ]);
                    $record->order->update([
                        'factory_id' => $record->factory_id
                    ]);
                    Notification::make()
                        ->success()
                        ->title('تم قبول الطلب بنجاح')
                        ->send();
                })
                ->color('success'),

            Action::make('reject')
                ->label('رفض')
                ->visible(
                    fn(FactoryOrder $record): bool =>
                    $record->status === StatusTypes::Pending
                )
                ->action(function (FactoryOrder $record) {
                    $record->update([
                        'status' => StatusTypes::Rejected
                    ]);
                    Notification::make()
                        ->danger()
                        ->title('تم رفض الطلب')
                        ->send();
                })
                ->color('danger'),

            Action::make('finished')
                ->label('تم الانتهاء')
                ->visible(
                    fn(FactoryOrder $record): bool =>
                    $record->status === StatusTypes::Accepted
                )
                ->action(function (FactoryOrder $record) {
                    $record->update([
                        'status' => StatusTypes::Finished
                    ]);
                    Notification::make()
                        ->success()
                        ->title('تم إنهاء الطلب بنجاح')
                        ->send();
                })
                ->color('primary')
                ->icon('heroicon-s-check'),

            Action::make('download_image')
                ->label('تحميل التصميم')
                ->icon('heroicon-o-arrow-down-tray') // أيقونة التحميل
                ->color('success')
                ->visible(
                    fn(FactoryOrder $record): bool =>
                    $record->status === StatusTypes::Accepted
                )
                ->hidden(fn($record) => !$record->order->design->image_front) // يخفي الزر إذا لم توجد صورة
                ->action(function ($record) {
                    // يمكنك هنا تنفيذ شيء مثل تتبع المشاركة أو فتح الصورة
                    return response()->download(storage_path('app/public/' . $record->order->design->logo_front));
                }),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Section::make('تفاصيل الطلب')->schema([
                TextEntry::make('order.id')->label('رقم الطلب'),
                TextEntry::make('status')->label('الحالة')->badge(),
            ])->columns(2),

            Section::make('معلومات العميل')->schema([
                TextEntry::make('order.customer.name')->label('الاسم')->default('-'),
                TextEntry::make('order.customer.phone')->label('رقم الهاتف')->default('-'),
            ])->columns(2),

            Section::make('معلومات المنتج والتصميم')->schema([
                TextEntry::make('order.design.title')->label('التصميم')->default('-'),
                TextEntry::make('order.design.product.price')
                    ->label('تكلفة المنتج')
                    ->formatStateUsing(fn($state) => number_format($state ?? 0, 2) . ' ر.س'),
                TextEntry::make('order.price')
                    ->label('سعر البيع')
                    ->formatStateUsing(fn($state) => number_format($state ?? 0, 2) . ' ر.س'),
            ])->columns(3),

            Section::make('ملخص الطلب')->schema([
                TextEntry::make('order.quantity')->label('الكمية')->default(0),
                TextEntry::make('order.total')
                    ->label('الإجمالي')
                    ->formatStateUsing(fn($state) => number_format($state ?? 0, 2) . ' ر.س'),
            ])->columns(2),

            Section::make('صور التصميم')->schema([
                Split::make([

                    ImageEntry::make('order.design.image_front')
                        ->label('الصورة الأمامية')
                        ->disk('public')
                        ->visibility('public')
                        ->height(300)
                        ->extraImgAttributes(['class' => 'cursor-zoom-in'])
                        ->extraAttributes(['onclick' => 'window.open(this.src)'])
                        ->hidden(fn($record) => empty($record->order->design->image_front)),

                ])->grow(false),
            ]),
        ]);
    }
}
