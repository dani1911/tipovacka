<?php

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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->enum('type', Type::cases());
            $table->unique(['id', 'type']);
        });

        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('abbreviation')->unique();
            $table->string('flag')->nullable();
        });

        Schema::create('clubs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('abbreviation');
            $table->string('logo')->nullable();
            $table->foreignId('country_id')->constrained();
        });

        Schema::create('national_teams', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->foreignId('country_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
        Schema::dropIfExists('countries');
        Schema::dropIfExists('clubs');
        Schema::dropIfExists('national_teams');
    }
};
