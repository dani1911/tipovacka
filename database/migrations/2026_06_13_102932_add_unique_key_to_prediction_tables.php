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
        Schema::table('game_predictions', function (Blueprint $table) {
            $table->unique(['game_id', 'user_id']);
        });

        Schema::table('stage_predictions', function (Blueprint $table) {
            $table->unique(['tournament_id', 'stage_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('game_predictions', function (Blueprint $table) {
            $table->dropUnique(['game_id', 'user_id']);
        });

        Schema::table('stage_predictions', function (Blueprint $table) {
            $table->dropUnique(['tournament_id', 'stage_id', 'user_id']);
        });
    }
};
