<?php

namespace App\Livewire\Home;

use App\Models\Game;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class HomeView extends Component
{
    public Collection $games;

    public Collection $users;

    public function mount(): void
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
            ->whereDate('game_time', today())
            ->with($with)
            ->get();

        // $this->users = User::withCount('correctPredictions')
        //     ->orderByDesc('correct_predictions_count')
        //     ->limit(5)
        //     ->get();
    }

    public function render()
    {
        return view('livewire.home.index', [
            'games' => $this->games,
            // 'users' => $this->users,
        ]);
    }
}