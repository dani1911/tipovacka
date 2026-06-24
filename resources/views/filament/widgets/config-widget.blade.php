<x-filament-widgets::widget>
    <x-filament::section heading="{{ __('Configuration') }}">
        <form class="fi-sc-form" wire:submit.prevent="save">
            {{ $this->form }}

            <div class="fi-ac fi-align-start">
                <x-filament::button type="submit">
                    {{ __('Save') }}
                </x-filament::button>
            </div>
        </form>
    </x-filament::section>
</x-filament-widgets::widget>