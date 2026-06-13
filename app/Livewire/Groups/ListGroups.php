<?php

namespace App\Livewire\Groups;

use App\Enums\Phase;
use App\Models\Stage;
use App\Models\StageTeam;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ListGroups extends Component
{
    public int $tournamentId;

    public bool $hasDeadlinePassed = false;

    protected $listeners = [
        'stage-prediction-saved' => '$refresh',
    ];

    public function mount()
    {
        $this->tournamentId = view()->shared('tournament')->id;
    }

    private function getUsers(): Collection
    {
        return User::whereHas('stagePredictions', fn($q) => $q->where('tournament_id', $this->tournamentId))
            ->with(['stagePredictions' => fn($q) => $q->where('tournament_id', $this->tournamentId)->with('team')])
            ->orderBy('name', 'asc')
            ->get()
            ->each(function ($user) {
                $user->setRelation(
                    'stagePredictions',
                    $user->stagePredictions->keyBy('stage_id')
                );
            });
    }

    private function getStages(): Collection
    {
        return Stage::whereIn(
                'id',
                StageTeam::with('stage')
                    ->where('tournament_id', $this->tournamentId)
                    ->distinct()
                    ->pluck('stage_id')
            )
            ->with(['stageWinner' => fn($q) => $q->where('tournament_id', $this->tournamentId)->with('team')])
            ->whereIn('phase', [Phase::GROUP, Phase::FINAL])
            ->get();
    }

    public function render()
    {
        $users = $this->getUsers();
        $tournament = Tournament::with('rulesets')->find($this->tournamentId);
        $this->hasDeadlinePassed = $tournament->rulesets->where('phase', Phase::GROUP)->first()?->hasDeadlinePassed() ?? false;

        return view('livewire.groups.list-groups', [
            'users' => $users,
            'stages' => $this->getStages(),
            'tournament' => $tournament,
            'hasDeadlinePassed' => $this->hasDeadlinePassed,
            'userHasPredictions' => $users->contains('id', auth()->id()),
        ]);
    }
}