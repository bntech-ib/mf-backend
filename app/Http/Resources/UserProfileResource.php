<?php
 
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
class UserProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            /* =========================
               Basic Info
            ==========================*/

            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'avatar' => $this->avatar,
            'bio' => $this->bio,

            /* =========================
               Favorite Club
            ==========================*/

            'favorite_club' => new ClubResource(
                $this->whenLoaded('favoriteClub')
            ),

            /* =========================
               Stats
            ==========================*/

            'posts_count' => $this->posts_count ?? 0,
            'followers_count' => $this->followers_count ?? 0,
            'following_count' => $this->following_count ?? 0,

            /* =========================
               Relationship to Viewer
            ==========================*/

            'is_followed' => (bool) ($this->is_followed ?? false),
            'is_self' => Auth::user()->id === $this->id,

            /* =========================
               Points / Fan System
            ==========================*/

            'points' => $this->points,
            'tier' => $this->tier ?? null,

            /* =========================
               Metadata
            ==========================*/

            'joined_at' => $this->created_at,
            'joined_at_human' => $this->created_at->diffForHumans(),
        ];
    }
}

