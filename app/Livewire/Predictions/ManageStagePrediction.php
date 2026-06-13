<?php

namespace App\Livewire\Predictions;

use App\Enums\Phase;
use App\Models\Stage;
use App\Models\StagePrediction;
use App\Models\StageTeam;
use App\Models\Tournament;
use App\Support\FlashToast;
use App\Traits\WithToast;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ManageStagePrediction extends Component
{
    use WithToast;

    public ?StagePrediction $stagePrediction = null;

    public ?Collection $stages = null;

    public ?Collection $stageTeams = null;

    public ?Tournament $tournament = null;

    public int $user_id;

    public array $predictions = [];

    public int $tournamentId;

    public function mount(): void
    {
        $this->tournament = Tournament::where('slug', request()->route('tournament'))->firstOrFail();
        $this->tournamentId = $this->tournament->id;

        $stagePredictions = StagePrediction::where('tournament_id', $this->tournamentId)
            ->where('user_id', auth()->id())
            ->get();

        foreach ($stagePredictions as $prediction) {
            $this->predictions[$prediction->stage_id] = $prediction->team_id;
        }
    }

    #[On('stagePredictionModal')]
    public function openModal(): void
    {
        $this->user_id = auth()->id();

        $this->stages = Stage::whereIn(
            'id',
            StageTeam::where('tournament_id', $this->tournamentId)
                ->distinct()
                ->pluck('stage_id')
            )->get();

        $this->stageTeams = StageTeam::where('tournament_id', $this->tournamentId)
            ->with('team')
            ->get()
            ->sortBy('team.name');

        $this->modal('stage-prediction-modal')->show();
    }

    public function save(): void
    {
        if (!$this->user_id) {
            FlashToast::error(__('You must be logged in to save a prediction.'));
            return;
        }

        $tournament = Tournament::with('rulesets')->find($this->tournamentId);

        $hasDeadlinePassed = $tournament->rulesets
            ->where('phase', Phase::GROUP)
            ->first()
            ?->hasDeadlinePassed() ?? false;

        if ($hasDeadlinePassed) {
            FlashToast::error(__('The prediction deadline has passed.'));
            $this->modal('stage-prediction-modal')->close();
            return;
        }

        foreach ($this->predictions as $stageId => $teamId) {
            $prediction = StagePrediction::where([
                'tournament_id' => $this->tournamentId,
                'stage_id' => $stageId,
                'user_id' => auth()->id(),
            ])->first();

            if ($prediction) {
                if ($prediction->user_id !== auth()->id()) {
                    FlashToast::error(__('You are not authorized to update this prediction.'));
                    continue;
                }
                $prediction->update(['team_id' => $teamId]);
            } else {
                StagePrediction::create([
                    'tournament_id' => $this->tournamentId,
                    'stage_id' => $stageId,
                    'user_id' => auth()->id(),
                    'team_id' => $teamId,
                ]);
            }
        }

        FlashToast::success(__('Predictions saved successfully.'));

        $this->dispatch('stage-prediction-saved');

        $this->modal('stage-prediction-modal')->close();
    }

    public function render()
    {
        return view('livewire.predictions.manage-stage-prediction');
    }
}