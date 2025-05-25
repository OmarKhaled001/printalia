<?php

namespace App\Filament\Designer\Resources\DesignResource\Pages;

use App\Filament\Designer\Resources\DesignResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDesign extends EditRecord
{
    protected static string $resource = DesignResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
