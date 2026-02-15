<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommunityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
  public function toArray($request)
    {
        return [

            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'logo' => $this->logo,

            'privacy' => $this->privacy,

            'owner' => [
                'id' => $this->owner->id,
                'name' => $this->owner->name,
                'avatar' => $this->owner->avatar,
            ],

            /* ===== Stats ===== */

            'members_count' => $this->members_count ?? 0,
            'posts_count' => $this->posts_count ?? 0,
            'online_members' => $this->online_members ?? null,

            /* ===== User Relationship ===== */

            'is_member' => (bool) ($this->is_member ?? false),
            'role' => $this->pivot->role ?? null,

            /* ===== Optional Features ===== */

            'has_chat' => true,
            'has_leaderboard' => true,

            'created_at' => $this->created_at,
        ];
    }
}
