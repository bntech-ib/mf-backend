<?php

namespace App\Listeners;

use App\Events\MatchFinished;  
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Models\FanSeasonStat;
use Illuminate\Support\Facades\DB;

class ProcessMatchRewards
{
    /**
     * Create the event listener.
     */
    public function __construct( )
    {
        //
    }

    /**
     * Handle the event.
     */
 public function handle(MatchFinished $event)
    {
        $match = $event->match; 

        $winner = null;

        if ($match->home_score > $match->away_score) {
            $winner = $match->home_club_id;
        } elseif ($match->away_score > $match->home_score) {
            $winner = $match->away_club_id;
        }

        if (!$winner) return;

        $fans = User::where('favorite_club_id', $winner)->get();

        foreach ($fans as $fan) {
            $fan->increment('points', 10);

            FanSeasonStat::updateOrCreate(
                ['user_id' => $fan->id, 'club_id' => $winner],
                ['total_points' => DB::raw('total_points + 10')]
            );
        }
    }
}
