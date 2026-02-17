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
        Schema::create('predictions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('match_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->integer('home_score_predicted');
            $table->integer('away_score_predicted');

            $table->integer('points_awarded')->default(0);
            $table->boolean('is_scored')->default(false);

            $table->timestamps();

            // One prediction per user per match
            $table->unique(['user_id', 'match_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('predictions');
    }
};
