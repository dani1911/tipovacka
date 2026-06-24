<?php

namespace App\Livewire\Games;

use App\Models\Game;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ManageGameScore extends Component
{
    public ?Game $game;

    #[Validate('required')]
    public $home_team_score = '';

    #[Validate('required')]
    public $away_team_score = '';

    public function setGame(Game $game)
    {
        $this->game = $game;
        $this->home_team_score = $game->home_team_score;
        $this->away_team_score = $game->away_team_score;
    }

    public function update()
    {
        $this->validate();

        $this->game->update(
            $this->only(['home_team_score', 'away_team_score'])
        );
    }
}
