<?php

namespace App\Livewire\Home;

use App\Enums\Phase;
use App\Models\Game;
use App\Models\Tournament;
use App\Models\User;
use App\Support\AppConfig;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class HomeView extends Component
{
    public Collection $games;

    public Tournament $tournament;

    public string $activeStage = 'group';

    public function mount(): void
    {
        $this->tournament = view()->shared('tournament');

        $this->activeStage = AppConfig::currentPhase()->value;

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
            ->limit(5)
            ->get();
// dd($users);
        return view('livewire.home.index', [
            'games' => $this->games,
            'users' => $users,
        ]);
    }
}