<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;

class DesignEditor extends Component
{
    use WithFileUploads;

    public $background;
    public $canvasId = 'canvas';
    public $targetImageInputName = 'image_front';
    public $targetLogosInputName = 'logo_front';
    public $initialLogos = [];
    public $textColor = '#000000';
    public $fontFamily = 'Arial';
    public $imageUpload;
    public $finalImage;
    public $logosJson;

    public function mount($background = null, $canvasId = 'canvas', $targetImageInputName = 'image_front', $targetLogosInputName = 'logo_front', $initialLogos = [])
    {
        $this->background = $background;
        $this->canvasId = $canvasId;
        $this->targetImageInputName = $targetImageInputName;
        $this->targetLogosInputName = $targetLogosInputName;
        $this->initialLogos = $initialLogos;
        $this->logosJson = json_encode($initialLogos);
    }

    public function triggerFileInput($inputId)
    {
        $this->dispatch('triggerFileInput', inputId: $inputId);
    }

    public function addText()
    {
        $this->dispatch('addText');
    }

    public function bringForward()
    {
        $this->dispatch('bringForward');
    }

    public function sendBackward()
    {
        $this->dispatch('sendBackward');
    }

    public function undo()
    {
        $this->dispatch('undo');
    }

    public function redo()
    {
        $this->dispatch('redo');
    }

    public function removeSelected()
    {
        $this->dispatch('removeSelected');
    }

    public function updatedImageUpload()
    {
        if ($this->imageUpload) {
            try {
                $dataUrl = $this->imageUpload->temporaryUrl();
                $this->dispatch('imageUploaded', dataUrl: $dataUrl);
                $this->imageUpload = null;
            } catch (\Exception $e) {
                Log::error("Image upload failed: " . $e->getMessage());
            }
        }
    }

    public function render()
    {
        return view('livewire.design-editor');
    }
}
