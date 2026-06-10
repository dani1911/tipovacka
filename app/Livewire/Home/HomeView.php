<?php

namespace App\Livewire\Home;

use App\Models\Game;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class HomeView extends Component
{
    public Collection $games;

    public Collection $users;

    public Tournament $tournament;

    public function mount(): void
    {
        $this->tournament = view()->shared('tournament');

        $with = [
            'stage',
            'tournament.rulesets',
            'homeTeam.club',
            'homeTeam.nationalTeam.country',
            'awayTeam.club',
            'awayTeam.nationalTeam.country',
            'userPrediction',
        ];

        $this->games = Game::where('tournament_id', $this->tournament->id)
            ->whereDate('game_time', today())
            ->with($with)
            ->get();

        $this->users = User::withSum(
            ['gamePredictions' => fn($q) => $q->whereHas('game', fn($q) => $q->where('tournament_id', $this->tournament->id))],
            'points'
        )
            ->withSum(
                ['stagePredictions' => fn($q) => $q->where('tournament_id', $this->tournament->id)],
                'points'
            )
            ->where(function ($query) {
                $query->whereHas('gamePredictions', fn($q) => $q->whereHas('game', fn($q) => $q->where('tournament_id', $this->tournament->id)))
                    ->orWhereHas('stagePredictions', fn($q) => $q->where('tournament_id', $this->tournament->id));
            })
            ->orderByRaw('(COALESCE(game_predictions_sum_points, 0) + COALESCE(stage_predictions_sum_points, 0)) DESC')
            ->limit(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.home.index', [
            'games' => $this->games,
            'users' => $this->users,
        ]);
    }
}