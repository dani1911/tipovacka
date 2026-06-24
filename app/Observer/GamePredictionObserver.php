<?php

namespace App\Observer;

use App\Models\GamePrediction;
use App\Traits\HandlesBracketAdvancement;

class GamePredictionObserver
{
    use HandlesBracketAdvancement;

    public function updated(GamePrediction $prediction): void
    {
        $this->advanceBracket($prediction);
    }
}