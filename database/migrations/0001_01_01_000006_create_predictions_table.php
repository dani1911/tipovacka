<?php

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
        Schema::create('game_predictions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('game_id')->constrained();
            $table->integer('home_team_goals')->nullable();
            $table->integer('away_team_goals')->nullable();
            $table->foreignId('advancing_team_id')->nullable();
            $table->integer('points')->nullable();
        });

        Schema::create('stage_predictions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('team_id')->constrained()->nullable();
            $table->foreignId('stage_id')->constrained()->nullable();
            $table->integer('points')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_predictions');
        Schema::dropIfExists('stage_predictions');
    }
};
