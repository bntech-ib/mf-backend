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
        Schema::create('fan_loyalty_scores', function (Blueprint $table) {
            $table->id();

            $table->foreignId('season_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('club_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->integer('score')->default(0);
            $table->string('tier')->default('Casual');

            $table->timestamps();

            $table->unique(['season_id', 'user_id', 'club_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fan_loyalty_scores');
    }
};
