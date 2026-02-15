<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeaderboardEntryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
  public function toArray($request)
    {
        return [
            'rank' => $this->rank,

            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'avatar' => $this->user->avatar,
                'favorite_club_id' => $this->user->favorite_club_id,
            ],

            'points' => (int) $this->points,

            'tier' => $this->tier ?? null,

            'is_current_user' =>
                auth()->check() && $this->user->id === auth()->id(),
        ];
    }
}
