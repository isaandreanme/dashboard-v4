<x-filament-panels::page>
    @foreach ($this->getWidgets() as $widget)
    @livewire($widget)
    @endforeach
</x-filament-panels::page>