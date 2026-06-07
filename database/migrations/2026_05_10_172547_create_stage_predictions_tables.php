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
        Schema::create('stage_predictions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained();
            $table->foreignId('stage_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('team_id')->nullable()->constrained();
            $table->tinyInteger('points')->default(0);
            $table->timestamps();
        });

        Schema::create('stage_winners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained();
            $table->foreignId('stage_id')->constrained();
            $table->foreignId('team_id')->constrained();
            $table->unique(['tournament_id', 'stage_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stage_predictions');
        Schema::dropIfExists('stage_winners');
    }
};
