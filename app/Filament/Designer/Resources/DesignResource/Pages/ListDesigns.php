<?php

namespace App\Filament\Designer\Resources\DesignResource\Pages;

use Filament\Actions;
use Filament\Tables\Actions\LinkAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Designer\Resources\DesignResource;
use Filament\Actions\Action;

class ListDesigns extends ListRecords
{
    protected static string $resource = DesignResource::class;


    protected function getHeaderActions(): array
    {
        return [
            Action::make('go_to_page')
                ->label('إضافة تصميم')
                ->url(route('editor')) // ملاحظة: هنا ما نحتاج fn() لأن ما في record
                ->icon('heroicon-o-pencil')
                ->openUrlInNewTab(),

        ];
    }
}
