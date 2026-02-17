<?php

namespace App\Jobs;

use App\Models\Matchs;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class scoreMatch implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
    }

    public function scoreMatch(Matchs $match)
{
    if ($match->status !== 'finished') return;

    foreach ($match->predictions as $prediction) {

        $points = 0;

        $actualHome = $match->home_score;
        $actualAway = $match->away_score;

        $predHome = $prediction->home_score_predicted;
        $predAway = $prediction->away_score_predicted;

        // Exact score
        if ($actualHome == $predHome && $actualAway == $predAway) {
            $points = 50;
        }
        // Correct winner or draw
        elseif (
            ($actualHome > $actualAway && $predHome > $predAway) ||
            ($actualHome < $actualAway && $predHome < $predAway) ||
            ($actualHome == $actualAway && $predHome == $predAway)
        ) {
            $points = 20;
        }

        $prediction->update([
            'points_awarded' => $points,
            'is_scored' => true,
        ]);

        // Add to user total points
        $prediction->user->increment('points', $points);
    }
}
}
