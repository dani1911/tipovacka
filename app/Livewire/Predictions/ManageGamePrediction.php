<?php

namespace App\Livewire\Predictions;

use App\Enums\Phase;
use App\Models\Game;
use App\Models\GamePrediction;
use App\Support\FlashToast;
use App\Traits\WithToast;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ManageGamePrediction extends Component
{
    use WithToast;

    public ?GamePrediction $gamePrediction = null;

    public int $game_id;
    public int $user_id;
    public string $mode;
    public int $home_team_id;
    public string $home_team_name;
    public string $home_team_image;
    public int $away_team_id;
    public string $away_team_name;
    public string $away_team_image;
    public bool $is_knockout = false;

    #[Validate('required')]
    public ?int $home_team_score;
    #[Validate('required')]
    public ?int $away_team_score;

    public ?int $winner_team_id = null;

    #[On('gamePredictionModal')]
    public function openModal(int $game_id, string $action): void
    {
        $this->game_id = $game_id;
        $this->user_id = auth()->id();
        $this->mode = $action;

        $game = Game::with([
            'stage',
            'homeTeam.nationalTeam.country',
            'homeTeam.club',
            'awayTeam.nationalTeam.country',
            'awayTeam.club',
        ])->findOrFail($game_id);

        $this->gamePrediction = GamePrediction::where('game_id', $game_id)
            ->where('user_id', $this->user_id)
            ->first();

        $this->home_team_id = $game->homeTeam?->id ?? $this->gamePrediction->homeTeam?->id;
        $this->home_team_name = $game->homeTeam?->name ?? $this->gamePrediction->homeTeam?->name;
        $this->home_team_image = $game->homeTeam?->image ?? $this->gamePrediction->homeTeam?->image;
        $this->away_team_id = $game->awayTeam?->id ?? $this->gamePrediction->awayTeam?->id;
        $this->away_team_name = $game->awayTeam?->name ?? $this->gamePrediction->awayTeam?->name;
        $this->away_team_image = $game->awayTeam?->image ?? $this->gamePrediction->awayTeam?->image;
        $this->is_knockout = in_array($game->stage->phase, [Phase::KNOCKOUT, Phase::FINAL, Phase::THIRDPLACE]);

        $this->home_team_score = $this->gamePrediction?->home_team_score;
        $this->away_team_score = $this->gamePrediction?->away_team_score;
        $this->winner_team_id = $this->gamePrediction?->winner_team_id
            ?? $this->home_team_id
            ?? 0;

        $this->modal('game-prediction-modal')->show();
    }

    /**
     * Saves user's game prediction.
     */
    public function save()
    {
        if (!$this->user_id) {
            FlashToast::error(__('You must be logged in to save a prediction.'));
            return;
        }

        $game = Game::with('stage')->findOrFail($this->game_id);

        if ($game->hasDeadlinePassed()) {
            FlashToast::error(__('The prediction deadline has passed.'));
            $this->modal('game-prediction-modal')->close();
            return;
        }

        $this->validate();

        if ($this->mode === 'create') {
            $prediction = GamePrediction::firstOrCreate(
                ['game_id' => $this->game_id, 'user_id' => $this->user_id],
                $this->only([
                    'home_team_id',
                    'away_team_id',
                    'home_team_score',
                    'away_team_score',
                    'winner_team_id'
                ])
            );

            if ($prediction->wasRecentlyCreated) {
                FlashToast::success(__('Prediction added successfully.'));
                $this->dispatch('game-prediction-saved');
                $this->modal('game-prediction-modal')->close();
                $this->reset(['home_team_score', 'away_team_score']);
            } else {
                FlashToast::warning(__('You already have a prediction for this game. Try refreshing the page.'));
                $this->modal('game-prediction-modal')->close();
            }
        } else {
            $this->update();
        }
    }

    /**
     * Updates existing game prediction.
     */
    public function update()
    {
        if ($this->gamePrediction->user_id !== $this->user_id) {
            FlashToast::error(__('You are not authorized to update this prediction.'));
            return;
        }

        if ($this->mode === 'edit') {
            $this->validate();

            $this->winner_team_id = $this->resolveWinner();

            $this->gamePrediction->update(
                $this->only(['home_team_score', 'away_team_score', 'winner_team_id'])
            );

            FlashToast::success(__('Prediction updated successfully.'));

            $this->dispatch('game-prediction-saved');

            $this->modal('game-prediction-modal')->close();

            $this->reset(['home_team_score', 'away_team_score']);
        }
    }

    /**
     * Determines advancing team for knockout round
     */
    private function resolveWinner(): ?int
    {
        if ($this->home_team_score > $this->away_team_score) {
            return $this->home_team_id;
        }

        if ($this->away_team_score > $this->home_team_score) {
            return $this->away_team_id;
        }

        return $this->winner_team_id ?: null;
    }

    public function render()
    {
        return view('livewire.predictions.manage-game-prediction');
    }
}