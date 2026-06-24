<?php

namespace App\Livewire\Knockout;

use App\Enums\Phase;
use App\Models\Game;
use App\Models\GamePrediction;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Bracket extends Component
{
    public Collection $games;

    public Collection $finalGame;

    public Collection $bronzeGame;

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
            ->whereHas('stage', fn($q) => $q->where('phase', Phase::KNOCKOUT))
            ->with($with)
            ->orderBy('game_number', 'asc')
            ->get();
        
        $this->finalGame = Game::where('tournament_id', $tournament->id)
            ->whereHas('stage', fn($q) => $q->where('phase', Phase::FINAL))
            ->with($with)
            ->get();

        $this->bronzeGame = Game::where('tournament_id', $tournament->id)
            ->whereHas('stage', fn($q) => $q->where('phase', Phase::THIRDPLACE))
            ->with($with)
            ->get();
    }

    public function render()
    {
        $gamesByStage = $this->games
            ->sortBy(fn($game) => [$game->stage->id, $game->game_number])
            ->groupBy(fn($game) => $game->stage_id);

        return view('livewire.knockout.bracket', [
            'games' => $this->games,
            'finalGame' => $this->finalGame,
            'bronzeGame' => $this->bronzeGame,
            'gamesByStage' => $gamesByStage,
        ]);
    }
}