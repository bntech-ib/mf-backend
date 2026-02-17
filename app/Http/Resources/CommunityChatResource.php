<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommunityChatResource extends JsonResource
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
            'name' => $this->name,
            'type' => $this->type,
            'is_private' => $this->is_private,
            'position' => $this->position,

            /* ======================
               Community
            ====================== */

            'community_id' => $this->community_id,

            /* ======================
               Creator
            ====================== */

            'created_by' => [
                'id' => $this->creator->id,
                'name' => $this->creator->name,
            ],

            /* ======================
               Activity
            ====================== */

            'last_message_at' => $this->last_message_at,

            'created_at' => $this->created_at,
        ];
    }


}
