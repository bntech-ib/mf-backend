<?php

namespace App\Services;

use App\Models\Seasion;
use App\Models\User;
use App\Models\Club;
use App\Models\FanLoyaltyScore;
use App\Models\Season;

class LoyaltyService
{
    public function addPoints(
        Season $season,
        User $user,
        Club $club,
        int $points
    ): void {
        $record = FanLoyaltyScore::firstOrCreate(
            [
                'season_id' => $season->id,
                'user_id'   => $user->id,
                'club_id'   => $club->id,
            ],
            [
                'score' => 0,
                'tier'  => 'Casual',
            ]
        );

        $record->increment('score', $points);

        $record->update([
            'tier' => fan_tier($record->score),
        ]);
    }

 
}




 