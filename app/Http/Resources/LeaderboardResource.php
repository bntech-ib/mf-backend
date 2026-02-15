<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeaderboardResource extends JsonResource
{
  public function toArray($request)
    {
        return [
            'leaderboard_type' => $this->type,
            'entity_id' => $this->entity_id,

            'top_fans' => LeaderboardEntryResource::collection(
                $this->entries
            ),

            'current_user_rank' => $this->current_user_rank,

            'total_participants' => $this->total_users,

            'updated_at' => now(),
        ];
    }
}

