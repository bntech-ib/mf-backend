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
        Schema::create('season_clubs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('season_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('club_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->integer('league_position')->nullable();

            $table->decimal('base_allocation', 14, 2)->default(0);
            $table->decimal('performance_multiplier', 5, 2)->default(1);
            $table->decimal('final_allocation', 14, 2)->default(0);

            $table->timestamps();

            $table->unique(['season_id', 'club_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('season_clubs');
    }
};
