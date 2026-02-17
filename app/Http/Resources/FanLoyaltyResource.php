<?php

namespace App\Http\Resources;
 
use Illuminate\Http\Resources\Json\JsonResource;

class FanLoyaltyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'season_id' => $this->season_id,
            'club'      => new ClubResource($this->whenLoaded('club')),
            'score'     => $this->score,
            'tier'      => $this->tier,
        ];
    }
}
