<?php

namespace App\Livewire\Games;

use App\Models\Game;
use App\Models\GamePrediction;
use App\Models\Tournament;
use Livewire\Component;

class ViewGame extends Component
{
    public Game $game;

    protected $listeners = [
        'game-prediction-saved' => '$refresh',
    ];

    public function mount(Game $game)
    {
        $this->game = $game;

        $tournament = Tournament::where('slug', request()->route('tournament'))->firstOrFail();

        abort_if($game->tournament_id !== $tournament->id, 404);
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