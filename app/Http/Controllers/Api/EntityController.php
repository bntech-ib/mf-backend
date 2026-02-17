<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClubResource;
use App\Http\Resources\CommunityResource;
use App\Http\Resources\LeaderboardEntryResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Models\Community;
use App\Models\User; 
use Illuminate\Support\Facades\Redis;
use App\Models\Club;

class EntityController extends Controller
{
    //

    private function resolveEntity(string $type, int $id)
{
    return match ($type) {
        'user' => User::findOrFail($id),
        'community' => Community::findOrFail($id),
        'club' => Club::findOrFail($id),
        default => abort(404, 'Invalid entity type'),
    };
}


public function show(string $type, int $id)
{
    $entity = $this->resolveEntity($type, $id);

    return match ($type) {
        'user' => new UserResource($entity),
        'community' => new CommunityResource($entity),
        'club' => new ClubResource($entity),
    };
}


public function feed(string $type, int $id)
{
    $entity = $this->resolveEntity($type, $id);

    $posts = $entity->posts()
        ->with('poster')
        ->withCount([
            'reactions as likes_count' => fn ($q) =>
                $q->where('type', 'like'),
            'comments'
        ])
        ->latest()
        ->cursorPaginate(15);

    return PostResource::collection($posts);
}


public function leaderboard(string $type, int $id)
{
    $key = "{$type}:leaderboard:{$id}";

    $data = Redis::zrevrange($key, 0, 19, 'WITHSCORES');

    $userIds = array_keys($data);

    $users = User::whereIn('id', $userIds)
        ->get()
        ->keyBy('id');

    $entries = collect($data)->map(function ($score, $userId) use ($users) {
        return (object)[
            'user' => $users[$userId] ?? null,
            'points' => (int) $score,
        ];
    })->values();

    $entries->each(fn ($e, $i) => $e->rank = $i + 1);

    return LeaderboardEntryResource::collection($entries);
}


public function members(string $type, int $id)
{
    if ($type !== 'community') {
        abort(404, 'Members only available for communities');
    }

    $community = Community::findOrFail($id);

    $members = $community->members()
        ->paginate(30);

    return UserResource::collection($members);
}

}
