<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PostResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
    
            return [
            'id' => $this->id,
            'content' => $this->content,
            'image' => $this->image,
            
            'author' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],

            'likes_count' => $this->likes_count,
            'comments_count' => $this->comments_count,
            'is_liked' => (bool) $this->is_liked,

            'created_at' => $this->created_at->diffForHumans(),
            'created_at_timestamp' => $this->created_at,
        ];
    }
}
