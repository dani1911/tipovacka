<?php

namespace App\Livewire\Users;

use App\Enums\Phase;
use App\Models\Game;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ViewUser extends Component
{
    public User $user;

    public Collection $groupGames;

    public Collection $knockoutGames;

    public int $tournamentId;

    public function mount(User $user)
    {
        $tournament = Tournament::where('slug', request()->route('tournament'))->firstOrFail();
        $this->tournamentId = $tournament->id;

        $this->user = $user;

        $this->groupGames = Game::where('tournament_id', $tournament->id)
            ->whereHas('stage', fn($q) => $q->where('phase', Phase::GROUP))
            ->with('userPrediction')
            ->get();

        $this->knockoutGames = Game::where('tournament_id', $tournament->id)
            ->whereHas('stage', fn($q) => $q->knockout())
            ->with('userPrediction')
            ->get();
    }

    public function render()
    {
        $user = User::withSum(
            ['gamePredictions' => fn($q) => $q->whereHas('game', fn($q) => $q->where('tournament_id', $this->tournamentId))],
            'points'
            )
            ->withSum(
                ['stagePredictions' => fn($q) => $q->where('tournament_id', $this->tournamentId)],
                'points'
            )
        ->find($this->user->id);

        $totalPoints = ($user->game_predictions_sum_points ?? 0) + ($user->stage_predictions_sum_points ?? 0);

        return view('livewire.users.view-user', compact('user', 'totalPoints'));
    }
}