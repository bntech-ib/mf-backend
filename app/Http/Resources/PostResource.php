<?php

namespace App\Http\Resources;
 
use Illuminate\Http\Resources\Json\JsonResource;
class PostResource extends JsonResource
{

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
public function toArray($request): array
    {
        return [

            /* =========================
               Core Post Info
            ==========================*/

            'id' => $this->id,
            'content' => $this->content,
            'media' => $this->media_url ?? false,

            /* =========================
               Poster (User/Community/Club)
            ==========================*/

            'poster' => new PosterResource($this->whenLoaded('poster'))??['name'=>'system'],

            /* =========================
               Engagement Metrics
            ==========================*/

            'likes_count' => $this->likes_count ?? 0,
            'comments_count' => $this->comments_count ?? 0,
            'shares_count' => $this->shares_count ?? 0,

            /* =========================
               Viewer State
            ==========================*/

            'is_liked' => (bool) ($this->is_liked ?? false),

            /* =========================
               Visibility & Permissions
            ==========================*/

            'visibility' => $this->visibility,
            'can_comment' => true,
            'can_share' => true,

            /* =========================
               Metadata
            ==========================*/

            'created_at'=> $this->created_at->diffForHumans(),

        ];
    }
}
