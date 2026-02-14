<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FanDashboardResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'user' => [
                'id' => $this->id,
                'name' => $this->name,
                'avatar' => $this->avatar,
                'points' => $this->points,
            ],

            'favorite_club' => new ClubResource($this->favoriteClub),

            'season_stats' => new FanSeasonStatResource(
                $this->seasonStat
            ),

            'recent_matches' => MatchResource::collection(
                $this->favoriteClub
                     ->homeMatches()
                     ->latest()
                     ->limit(5)
                     ->get()
            ),

            'leaderboard_position' => $this->leaderboard_position,
        ];
    }
}
