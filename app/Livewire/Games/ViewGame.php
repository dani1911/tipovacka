<?php

namespace App\Livewire\Games;

use App\Models\Game;
use App\Models\GamePrediction;
use App\Models\Tournament;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ViewGame extends Component
{
    public Game $game;

    public Tournament $tournament;

    protected $listeners = [
        'game-prediction-saved' => '$refresh',
    ];

    public function boot() {
        $param = request()->route('tournament');

        if (!$param) return;

        $this->tournament = $param instanceof Tournament
            ? $param
            : Tournament::where('slug', $param)->first();
    }    

    public function mount(Game $game)
    {
        $this->game = $game;

        abort_if($game->tournament_id !== $this->tournament->id, 404);
    }

    public function render()
    {
        $predictions = GamePrediction::whereBelongsTo($this->game)
            ->with([
                'user',
                'homeTeam.club',
                'homeTeam.nationalTeam.country',
                'awayTeam.club',
                'awayTeam.nationalTeam.country',
                'winnerTeam.club',
                'winnerTeam.nationalTeam.country',
            ])
            ->join('users', 'game_predictions.user_id', '=', 'users.id')
            ->orderBy('users.name')
            ->select('game_predictions.*')
            ->get();

        [$validPredictions, $invalidPredictions] = $predictions->partition(
            fn($prediction) => !$this->game->home_team_id || !$this->game->away_team_id
                || ($prediction->home_team_id === $this->game->home_team_id)
                && ($prediction->away_team_id === $this->game->away_team_id)
        );

        return view('livewire.games.view-game', compact('predictions', 'validPredictions', 'invalidPredictions'));
    }
}