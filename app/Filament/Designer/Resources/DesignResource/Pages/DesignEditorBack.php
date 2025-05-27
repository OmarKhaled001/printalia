<?php

namespace App\Filament\Designer\Resources\DesignResource\Pages;

use App\Filament\Designer\Resources\DesignResource;
use Filament\Resources\Pages\Page;

class DesignEditorBack extends Page
{
    protected static string $resource = DesignResource::class;

    protected static string $view = 'filament.designer.resources.design-resource.pages.design-editor-back';
}
