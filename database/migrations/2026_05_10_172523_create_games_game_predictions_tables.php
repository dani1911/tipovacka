<?php

use App\Enums\AdvancementResult;
use App\Enums\DestinationPosition;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained();
            $table->string('game_number', length: 6);
            $table->foreignId('stage_id')->constrained();
            $table->foreignId('home_team_id')->constrained('teams', 'id')->nullable();
            $table->foreignId('away_team_id')->constrained('teams', 'id')->nullable();
            $table->tinyInteger('home_team_score')->nullable();
            $table->tinyInteger('away_team_score')->nullable();
            $table->foreignId('winner_team_id')->nullable()->constrained('teams', 'id');
            $table->timestamp('game_time', precision: 0);
        });

        Schema::create('game_predictions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->tinyInteger('home_team_score')->nullable();
            $table->tinyInteger('away_team_score')->nullable();
            $table->foreignId('winner_team_id')->nullable()->constrained('teams', 'id');
            $table->tinyInteger('points')->default(0);
            $table->timestamps();
        });

        Schema::create('game_advancements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('source_game_id')->constrained('games', 'id');
            $table->foreignId('destination_game_id')->constrained('games', 'id');
            $table->enum('result', AdvancementResult::cases());
            $table->enum('destination_position', DestinationPosition::cases());
            $table->unique(['destination_game_id', 'destination_position'], 'destination_game_position_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
        Schema::dropIfExists('game_predictions');
        Schema::dropIfExists('game_advancements');
    }
};
