<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PredictionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
                return [
            'id' => $this->id,

            'match' => [
                'id' => $this->match->id,
                'home_club_id' => $this->match->home_club_id,
                'away_club_id' => $this->match->away_club_id,
                'kickoff_at' => $this->match->kickoff_at,
            ],

            'predicted_score' => [
                'home' => $this->home_score_predicted,
                'away' => $this->away_score_predicted,
            ],

            'points_awarded' => $this->points_awarded,
            'is_scored' => $this->is_scored,
        ];
    }
}
