<x-filament::page>
    <x-filament-panels::form wire:submit.prevent="submit">
        {{ $this->form }}

        <x-filament::button type="submit">
            {{ __('حفظ') }}
        </x-filament::button>
    </x-filament-panels::form>
</x-filament::page>
