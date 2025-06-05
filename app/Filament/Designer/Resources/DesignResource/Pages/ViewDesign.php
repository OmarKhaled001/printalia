<?php

namespace App\Filament\Designer\Resources\DesignResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Grid;
use Filament\Tables\Actions\LinkAction;
use Filament\Infolists\Components\Group;
use Filament\Resources\Pages\ViewRecord;
use Filament\Resources\Pages\ListRecords;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use App\Filament\Designer\Resources\DesignResource;

class ViewDesign extends ViewRecord
{
    protected static string $resource = DesignResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Grid::make(3) // Defines a 3-column grid for the infolist
                ->schema([
                    Section::make('الصور')
                        ->columnSpan(2) // This section will take 2 out of 3 columns
                        ->schema([
                            ImageEntry::make('image_front')
                                ->label('صورة أمامية')
                                ->hidden(fn($record) => !$record->image_front),

                            ImageEntry::make('logo_front')
                                ->label('شعار أمامي')
                                ->hidden(fn($record) => !$record->logo_front),
                            ImageEntry::make('image_back')
                                ->label('صورة خلفية')
                                ->hidden(fn($record) => !$record->image_back),
                            ImageEntry::make('logo_back')
                                ->label('شعار خلفي')
                                ->hidden(fn($record) => !$record->logo_back),


                        ])->columns(2), // Images within this section can still be in 2 columns

                    Section::make('بيانات التصميم')
                        ->columnSpan(1) // This section will take 1 out of 3 columns
                        ->schema([
                            Group::make([
                                TextEntry::make('title')->label('العنوان'),
                                TextEntry::make('description')->label('الوصف')->hidden(fn($record) => !$record->description),
                                TextEntry::make('product.price')->label('سعر المصنع')->money('SAR'),
                                TextEntry::make('sale_price')->label('سعر البيع')->money('SAR'),
                                TextEntry::make('profit')
                                    ->badge()
                                    ->label('الربح')
                                    ->money('SAR')
                                    // Calculate profit dynamically
                                    ->getStateUsing(function ($record): string {
                                        $salePrice = (float) $record->sale_price;
                                        $factoryPrice = (float) ($record->product->price ?? 0); // Access product price safely

                                        $profit = $salePrice - $factoryPrice;

                                        return (string) $profit; // Return as a string for display
                                    }),
                                TextEntry::make('created_at')->label('تاريخ الإنشاء')->dateTime(),
                            ])->columns(1), // Data within this section can be in 1 column
                        ]),
                ]),
        ]);
    }
}
