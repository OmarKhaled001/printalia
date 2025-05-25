<?php

// app/Filament/Forms/Components/DesignEditor.php
namespace App\Filament\Forms\Components;

use Closure;
use Filament\Forms\Components\Field;

class DesignEditor extends Field
{
    protected string $view = 'filament.forms.components.design-editor';

    protected string|Closure|null $backgroundImage = null;

    public function backgroundImage(string|Closure $image): static
    {
        $this->backgroundImage = $image;
        return $this;
    }

    public function getBackgroundImage(): ?string
    {
        return $this->evaluate($this->backgroundImage);
    }
}
