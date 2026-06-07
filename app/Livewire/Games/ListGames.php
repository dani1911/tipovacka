<?php

namespace App\Livewire\Games;

use App\Enums\Phase;
use App\Models\Game;
use App\Models\GamePrediction;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ListGames extends Component
{
    public Collection $games;

    public ?GamePrediction $gamePrediction = null;

    protected $listeners = [
        'game-prediction-saved' => '$refresh',
    ];

    public function mount()
    {
        $tournament = view()->shared('tournament');

        $with = [
            'stage',
            'tournament.rulesets',
            'homeTeam.club',
            'homeTeam.nationalTeam.country',
            'awayTeam.club',
            'awayTeam.nationalTeam.country',
            'userPrediction',
        ];

        $this->games = Game::where('tournament_id', $tournament->id)
            ->whereHas('stage', fn($q) => $q->where('phase', Phase::GROUP))
            ->with($with)
            ->get();
    }

    public function render()
    {
        return view('livewire.games.list-games', ['games' => $this->games]);
    }
}
