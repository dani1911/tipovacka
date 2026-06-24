<?php

namespace App\Livewire\Users;

use App\Actions\PopulateBracket;
use App\Enums\Phase;
use App\Models\Game;
use App\Models\GamePrediction;
use App\Models\StagePrediction;
use App\Models\Tournament;
use App\Models\User;
use App\Support\AppConfig;
use App\Support\FlashToast;
use App\Traits\WithToast;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ViewUser extends Component
{
    use WithToast;

    public User $user;

    public Collection $groupGames;

    public Collection $knockoutPredictions;

    public Collection $finalGame;

    public Collection $bronzeGame;

    public Collection $stagePredictions;

    public int $tournamentId;
    
    public bool $hasDeadlinePassed = false;

    public bool $hasBracket = false;

    public string $activeStage = 'group';

    public string $activeTab = 'games';

    protected $listeners = [
        'game-prediction-saved' => 'handlePredictionSaved',
        'bracket-created' => '$refresh',
    ];

    public function mount(User $user)
    {
        $tournament = Tournament::where('slug', request()->route('tournament'))->firstOrFail();
        $this->tournamentId = $tournament->id;

        $this->activeStage = AppConfig::currentPhase()->value;

        $this->user = $user;

        $this->groupGames = Game::where('tournament_id', $tournament->id)
            ->whereHas('stage', fn($q) => $q->where('phase', Phase::GROUP))
            ->with(['gamePredictions', 'userPrediction'])
            ->get();

        $with = [
            'game',
            'game.stage',
            'homeTeam.club',
            'homeTeam.nationalTeam.country',
            'awayTeam.club',
            'awayTeam.nationalTeam.country',
        ];

        $this->knockoutPredictions = GamePrediction::where('user_id', $user->id)
            ->whereHas('game', fn($q) => $q->where('tournament_id', $tournament->id))
            ->whereHas('game.stage', fn($q) => $q->where('phase', Phase::KNOCKOUT))
            ->with($with)
            ->get()
            ->sortBy(fn($prediction) => $prediction->game->game_number);

        $this->finalGame = GamePrediction::where('user_id', $user->id)
            ->whereHas('game', fn($q) => $q->where('tournament_id', $tournament->id))
            ->whereHas('game.stage', fn($q) => $q->where('phase', Phase::FINAL))
            ->with($with)
            ->get();

        $this->bronzeGame = GamePrediction::where('user_id', $user->id)
            ->whereHas('game', fn($q) => $q->where('tournament_id', $tournament->id))
            ->whereHas('game.stage', fn($q) => $q->where('phase', Phase::THIRDPLACE))
            ->with($with)
            ->get();

        $this->stagePredictions = StagePrediction::where('tournament_id', $tournament->id)
            ->where('user_id', $this->user->id)
            ->with(['team', 'stage', 'stageWinner'])
            ->get()
            ->sortBy('stage.name');

        $ruleset = $tournament->rulesets->where('phase', Phase::KNOCKOUT)->first();

        $this->hasDeadlinePassed = ($ruleset?->hasDeadlinePassed() ?? false);

        $this->hasBracket = GamePrediction::where('user_id', auth()->id())
            ->whereHas('game', fn($q) => $q->where('tournament_id', $tournament->id))
            ->whereHas('game.stage', fn($q) => $q->where('phase', Phase::KNOCKOUT))
            ->exists();
    }

    public function createBracket(): void
    {
        $tournament = Tournament::find($this->tournamentId);

        $error = app(PopulateBracket::class)->handle($tournament, auth()->id());

        if ($error === null) {
            $this->hasBracket = true;
            FlashToast::success(__('Bracket created successfully.'));
            $this->dispatch('bracket-created');
            return;
        }

        match ($error) {
            'already_exists' => FlashToast::warning(__('You already have a bracket for this tournament.')),
            'deadline_passed' => FlashToast::error(__('The prediction deadline has passed.')),
            'no_games' => FlashToast::error(__('No knockout games found for this tournament yet.')),
        };
    }

    public function render()
    {
        $isGroupPhase = $this->activeStage === Phase::GROUP->value;

        $knockoutPhaseValues = array_map(fn($p) => $p->value, Phase::knockoutPhases());

        $user = User::withSum(
            [
                'gamePredictions' => fn($q) => $q
                    ->whereHas(
                        'game',
                        fn($q) => $q
                            ->where('tournament_id', $this->tournamentId)
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
                            ->where('tournament_id', $this->tournamentId)
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
                                ->where('tournament_id', $this->tournamentId)
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
                            ->where('tournament_id', $this->tournamentId)
                            ->whereHas(
                                'stage',
                                fn($q) => $q
                                    ->whereIn('phase', [Phase::GROUP->value, Phase::FINAL->value])
                            )
                    );
                }
            })
            ->find($this->user->id);

        $totalPoints = ($user->game_predictions_sum_points ?? 0) + ($user->stage_predictions_sum_points ?? 0);

        $gamesByStage = $this->knockoutPredictions
            ->sortBy(fn ($prediction) => $prediction->game->stage->order)
            ->groupBy(fn ($prediction) => $prediction->game->stage_id);

        $eliminatedTeamIds = $this->resolveEliminatedTeams($this->knockoutPredictions);

        return view('livewire.users.view-user', compact('user', 'totalPoints', 'gamesByStage', 'eliminatedTeamIds'));
    }

    /**
     * Resolves teams that were eliminated from the tournament.
     */
    private function resolveEliminatedTeams(Collection $predictions): array
    {
        $eliminated = [];

        foreach ($predictions as $prediction) {
            $game = $prediction->game;

            if (!$game->winner_team_id) {
                continue;
            }

            $eliminated[] = $game->getLoser();
        }

        return array_unique(array_filter($eliminated));
    }

    public function handlePredictionSaved(): void
    {
        $this->dispatch('bracket-updated');
    }
}