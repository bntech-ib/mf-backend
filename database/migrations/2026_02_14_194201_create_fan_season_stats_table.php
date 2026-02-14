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
        Schema::create('fan_season_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('club_id')->constrained();
            $table->integer('matches_engaged')->default(0);
            $table->integer('content_posts')->default(0);
            $table->integer('comments_made')->default(0);
            $table->integer('total_points')->default(0);
            $table->timestamps();

            $table->unique(['user_id', 'club_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fan_season_stats');
    }
};
