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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            /* =========================
       Who created the post
       (User / Community / Club)
    ==========================*/

            $table->morphs('poster');

            /* =========================
       Where the post is posted
       (Optional community context)
    ==========================*/

            $table->foreignId('community_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            /* =========================
       Content
    ==========================*/

            $table->text('content');
            $table->string('media_url')->nullable();

            /* =========================
       Visibility
    ==========================*/

            $table->enum('visibility', [
                'public',
                'members',
                'followers',
                'private'
            ])->default('public');

            $table->timestamps();

            /* =========================
       Indexes
    ==========================*/

            $table->index(['poster_id', 'poster_type']);
            $table->index('community_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
