<?php

namespace App\Filament\Pages;

use App\Enums\Phase;
use App\Models\Game;
use App\Models\Stage;
use Filament\Pages\Page;

class Knockout extends Page
{
    // public ?array $games = [];

    protected string $view = 'filament.pages.knockout';

    protected static ?string $navigationParentItem = 'Games';

    public static function getNavigationLabel(): string
    {
        return __('Knockout Management');
    }

    public function mount(): void
    {
        // TODO have a tournament buttons at the top and get the data based on that
        $this->games = Game::where('tournament_id', 1)->whereIn('stage_id', [14,15,16,17,18])->get(); // TODO do not hardcode
        $this->stages = Stage::whereIn('phase', [Phase::KNOCKOUT,Phase::THIRDPLACE,Phase::FINAL])->get(); // TODO perhaps add to 
        // $this->advancements = GameAdvancement::with([...])->get();
    }

    public function getViewData(): array
    {
        return [
            'games' => $this->games,
            'stages' => $this->stages,
            // 'advancements' => $this->advancements,
        ];
    }
}
