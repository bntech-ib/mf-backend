<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PosterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
 public function toArray($request)
    {
        $type = class_basename($this->resource);

        return match ($type) {

            'User' => [
                'type' => 'user',
                'id' => $this->id,
                'name' => $this->name,
                'avatar' => $this->avatar,
                'username' => $this->username,
            ],

            'Community' => [
                'type' => 'community',
                'id' => $this->id,
                'name' => $this->name,
                'logo' => $this->logo,
                'members_count' => $this->members_count ?? null,
            ],

            'Club' => [
                'type' => 'club',
                'id' => $this->id,
                'name' => $this->name,
                'logo' => $this->logo,
                'league' => $this->league,
            ],
        };
    }
}
