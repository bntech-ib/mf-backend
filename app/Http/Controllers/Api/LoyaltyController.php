<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FanLoyaltyResource; 
use App\Models\Season;
use App\Models\User; 

class LoyaltyController extends Controller
{
    //

     public function userClubLoyalty(User $user, Season $season)
    {
        $scores = $user->loyaltyScores()
            ->where('season_id', $season->id)
            ->with('club')
            ->get();

        return FanLoyaltyResource::collection($scores);
    }
}
