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
        Schema::create('match_engagements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('match_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->boolean('predicted')->default(false);
            $table->boolean('commented')->default(false);
            $table->boolean('shared')->default(false);
             $table->unique(['match_id', 'user_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_engagements');
    }
};
