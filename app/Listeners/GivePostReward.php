<?php

namespace App\Listeners;

use App\Events\PostCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue; 

class GivePostReward implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
 
    public function handle(PostCreated $event): void
    {
        $user = $event->post->user;

        $user->increment('points', 10);

        // Optional: log reward
        // RewardLog::create([...]);
    }
}
