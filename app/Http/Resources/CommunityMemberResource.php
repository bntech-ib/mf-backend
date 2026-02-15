<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommunityMemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
   public function toArray($request)
    {
        return [
            'user_id' => $this->id,
            'name' => $this->name,
            'avatar' => $this->avatar,

            'role' => $this->pivot->role ?? 'member',

            'joined_at' => $this->pivot->created_at ?? null,

            'is_online' => $this->is_online ?? false,
        ];
    }
}
