<?php

use App\Enums\Phase;
use App\Enums\Type;
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
        Schema::create('stages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('abbreviation');
            $table->enum('phase', Phase::cases());
        });

        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('abbreviation');
            $table->string('logo')->nullable();
            $table->string('slug')->unique();
            $table->boolean('is_active')->default(false);
            $table->enum('type', Type::cases());
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
        });

        Schema::create('rulesets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained();
            $table->foreignId('stage_id')->constrained();
            $table->tinyInteger('points_exact_score')->default(0);
            $table->tinyInteger('points_match_winner')->default(0);
            $table->tinyInteger('points_group_winner')->default(0);
            $table->tinyInteger('points_tournament_winner')->default(0);
            $table->timestamp('deadline');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stages');
        Schema::dropIfExists('tournaments');
        Schema::dropIfExists('rulesets');
    }
};
