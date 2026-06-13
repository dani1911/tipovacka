<?php

namespace App\Livewire\Games;

use App\Models\Game;
use App\Models\GamePrediction;
use App\Models\Tournament;
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
            ->with('user')
            ->join('users', 'game_predictions.user_id', '=', 'users.id')
            ->orderBy('users.name')
            ->select('game_predictions.*')
            ->get();

        return view('livewire.games.view-game', compact('predictions'));
    }
}