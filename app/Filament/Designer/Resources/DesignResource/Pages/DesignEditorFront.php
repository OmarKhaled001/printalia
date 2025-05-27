<?php

namespace App\Filament\Designer\Resources\DesignResource\Pages;

use App\Models\Design;
use Filament\Resources\Pages\Page;
use App\Filament\Designer\Resources\DesignResource;

class DesignEditorFront extends Page
{
    protected static string $resource = DesignResource::class;

    protected static string $view = 'filament.designer.resources.design-resource.pages.design-editor-front';
    protected static ?string $navigationLabel = 'تصميم أمامي';
    protected static ?string $title = 'محرر التصميم الأمامي';

    protected Design $record;

    public function mount($record): void
    {
        $this->record = Design::findOrFail($record);
    }

    public function getViewData(): array
    {
        return [
            'background' => asset('storage/' . $this->record->background_image_front),
            'logo' => asset('storage/' . $this->record->logo_front),
            'targetInputId' => 'final_design_front',
        ];
    }
}
