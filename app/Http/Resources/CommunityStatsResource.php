<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommunityStatsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'members' => $this->members_count,
            'posts' => $this->posts_count,
            'comments' => $this->comments_count,
            'engagement_score' => $this->engagement_score,
            'active_today' => $this->active_today,
        ];
    }
}
