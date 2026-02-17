<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClubResource;
use App\Http\Resources\ClubStatsResource;
use App\Http\Resources\LeaderboardEntryResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Models\Club;
use App\Models\User; 
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;

class ClubController extends Controller
{
    //


    public function index()
{
    $clubs = Club::withCount('fans')
        ->latest()
        ->paginate(20);

    return ClubResource::collection($clubs);
}

public function show(Club $club)
{
    $club->loadCount(['fans', 'posts']);

    return new ClubResource($club);
}


public function feed(Club $club)
{
    $posts = $club->posts()
        ->with('poster')
        ->withCount([
            'reactions as likes_count' => fn ($q) =>
                $q->where('type', 'like'),
            'comments'
        ])
        ->withExists([
            'reactions as is_liked' => fn ($q) =>
                $q->where('type', 'like')
                  ->where('user_id', Auth::user()->id)
        ])
        ->latest()
        ->cursorPaginate(15);

    return PostResource::collection($posts);
}


public function fans(Club $club)
{
    $fans = $club->fans()
        ->latest()
        ->paginate(30);

    return UserResource::collection($fans);
}



public function leaderboard(Club $club)
{
    $key = "club:leaderboard:{$club->id}";

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

    $entries->each(function ($entry, $i) {
        $entry->rank = $i + 1;
    });

    return LeaderboardEntryResource::collection($entries);
}


public function stats(Club $club)
{
    $club->loadCount(['fans', 'posts']);

    $club->engagement_score =
        ($club->posts_count * 2) +
        ($club->fans_count);

    return new ClubStatsResource($club);
}







}
