<?php

namespace App\Models;

use App\Models\Game;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


#[Fillable(['source_game_id', 'destination_game_id', 'result', 'destination_position'])]
#[WithoutTimestamps]
class GameAdvancement extends Model
{
    /**
     * Gets the source game for advancing team.
     */
    public function sourceGame(): BelongsTo
    {
        return $this->belongsTo(Game::class, 'source_game_id');
    }

    /**
     * Gets the destination game a team advances to.
     */
    public function destinationGame(): BelongsTo
    {
        return $this->belongsTo(Game::class, 'destination_game_id');
    }
}
