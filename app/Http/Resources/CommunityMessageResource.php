<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommunityMessageResource extends JsonResource
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

            /* ======================
               Sender
            ====================== */

            'sender' => [
                'id' => $this->sender->id,
                'name' => $this->sender->name,
                'avatar' => $this->sender->avatar ?? null,
            ],

            /* ======================
               Content
            ====================== */

            'content' => $this->content,
            'media'   => $this->media_url,

            /* ======================
               Reply Info
            ====================== */

            'parent_id' => $this->parent_id,

            /* ======================
               Metadata
            ====================== */

            'is_edited' => $this->is_edited,

            'created_at' => $this->created_at,
            'created_at_human' =>
                $this->created_at->diffForHumans(),
        ];
    }
}
