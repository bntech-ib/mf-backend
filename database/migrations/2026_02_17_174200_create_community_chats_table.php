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
        Schema::create('community_chats', function (Blueprint $table) {
            $table->id(); 

            $table->foreignId('community_id')
                ->constrained('communities')
                ->cascadeOnDelete();

            $table->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('name');

            // Chat type (future-proof)
            $table->enum('type', [
                'general',
                'match',
                'announcement',
                'private'
            ])->default('general');

            // Visibility
            $table->boolean('is_private')->default(false);

            // For ordering channels
            $table->integer('position')->default(0);

            // Cached activity
            $table->timestamp('last_message_at')->nullable();
 
            // Useful indexes
            $table->index(['community_id', 'position']);
            $table->index('last_message_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_chats');
    }
};
