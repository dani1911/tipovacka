<?php

namespace App\Livewire\Users;

use App\Enums\Phase;
use App\Models\Tournament;
use App\Models\User;
use App\Support\AppConfig;
use Livewire\Component;

class ListUsers extends Component
{
    public Tournament $tournament;

    public string $activeStage = 'group';
    
    public function mount()
    {
        $this->tournament = view()->shared('tournament');

        $this->activeStage = AppConfig::currentPhase()->value;
    }

    public function render()
    {
        $isGroupPhase = $this->activeStage === Phase::GROUP->value;

        $knockoutPhaseValues = array_map(fn($p) => $p->value, Phase::knockoutPhases());

        $users = User::withSum(
                [
                    'gamePredictions' => fn($q) => $q
                        ->whereHas(
                            'game',
                            fn($q) => $q
                                ->where('tournament_id', $this->tournament->id)
                                ->whereHas(
                                    'stage',
                                    fn($q) => $isGroupPhase
                                        ? $q->where('phase', Phase::GROUP)
                                        : $q->whereIn('phase', $knockoutPhaseValues)
                                )
                        )
                ],
                'points'
            )
            ->when(
                $isGroupPhase,
                fn($q) => $q->withSum(
                    [
                        'stagePredictions' => fn($q) => $q
                            ->where('tournament_id', $this->tournament->id)
                            ->whereHas(
                                'stage',
                                fn($q) => $q
                                    ->whereIn('phase', [Phase::GROUP->value, Phase::FINAL->value])
                            )
                    ],
                    'points'
                ),
                fn($q) => $q->withSum(
                    ['stagePredictions' => fn($q) => $q->whereRaw('1 = 0')],
                    'points'
                )
            )
            ->where(function ($query) use ($isGroupPhase, $knockoutPhaseValues) {
                $query->whereHas(
                    'gamePredictions',
                    fn($q) => $q
                        ->whereHas(
                            'game',
                            fn($q) => $q
                                ->where('tournament_id', $this->tournament->id)
                                ->whereHas(
                                    'stage',
                                    fn($q) => $isGroupPhase
                                        ? $q->where('phase', Phase::GROUP)
                                        : $q->whereIn('phase', $knockoutPhaseValues)
                                )
                        )
                );

                if ($isGroupPhase) {
                    $query->orWhereHas(
                        'stagePredictions',
                        fn($q) => $q
                            ->where('tournament_id', $this->tournament->id)
                            ->whereHas(
                                'stage',
                                fn($q) => $q
                                    ->whereIn('phase', [Phase::GROUP->value, Phase::FINAL->value])
                            )
                    );
                }
            })
            ->orderByRaw('(COALESCE(game_predictions_sum_points, 0) + COALESCE(stage_predictions_sum_points, 0)) DESC')
            ->get();

        return view('livewire.users.list-users', ['users' => $users]);
    }
}