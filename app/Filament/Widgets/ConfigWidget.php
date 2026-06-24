<?php

namespace App\Filament\Widgets;

use App\Enums\Phase;
use App\Models\Configuration;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Widgets\Widget;
use Filament\Notifications\Notification;

class ConfigWidget extends Widget implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.widgets.config-widget';

    protected int|string|array $columnSpan = 'full';

    public ?string $current_phase = null;

    public function mount(): void
    {
        $this->current_phase = Configuration::get('CURRENT_PHASE');
    }

    protected function getFormSchema(): array
    {
        return [
            Select::make('current_phase')
                ->label(__('Current Phase'))
                ->options(
                    collect(Phase::cases())->mapWithKeys(
                        fn(Phase $phase) => [$phase->value => $phase->name]
                    )
                )
                ->required(),
        ];
    }

    public function save(): void
    {
        Configuration::set('CURRENT_PHASE', $this->current_phase);

        Notification::make()
            ->title('Configuration saved.')
            ->success()
            ->send();
    }
}
