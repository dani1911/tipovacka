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
            $table->foreignId('home_team_id')->after('user_id')->nullable();
            $table->foreignId('away_team_id')->after('home_team_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('game_predictions', function (Blueprint $table) {
            $table->dropColumn('home_team_id');
            $table->dropColumn('away_team_id');
        });
    }
};
