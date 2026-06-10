<?php

namespace App\Livewire\Users;

use App\Models\Tournament;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ListUsers extends Component
{
    public Collection $users;

    public Tournament $tournament;
    
    public function mount()
    {
        $this->tournament = view()->shared('tournament');
        
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
            ->get();
    }

    public function render()
    {
        return view('livewire.users.list-users', ['users' => $this->users]);
    }
}