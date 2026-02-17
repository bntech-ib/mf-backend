<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommunityMemberResource;
use App\Http\Resources\CommunityResource;
use App\Http\Resources\CommunityStatsResource;
use App\Http\Resources\LeaderboardEntryResource;
use App\Http\Resources\PostResource;
use App\Models\Community;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;

class CommunityController extends Controller
{
    //

public function index()
{
    $communities = Community::with('owner')
        ->withCount(['members', 'posts'])
        ->latest()
        ->paginate(20);

    return CommunityResource::collection($communities);
}
 

    public function show(Community $community)
{
    $community->load('owner')
        ->loadCount(['members', 'posts'])
        ->loadExists([
            'members as is_member' => fn ($q) =>
                $q->where('user_id', Auth::user())
        ]);

    return new CommunityResource($community);
}



public function feed(Community $community)
{
    $posts = $community->posts()
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
        ->cursorPaginate(15); // better than paginate()

    return PostResource::collection($posts);
}



public function members(Community $community)
{
    $members = $community->members()
        ->withPivot('role')
        ->latest()
        ->paginate(30);

    return CommunityMemberResource::collection($members);
}



public function leaderboard(Community $community)
{
    $key = "community:leaderboard:{$community->id}";

    // Get top 20 users with scores
    $data = Redis::zrevrange($key, 0, 19, 'WITHSCORES');

    $userIds = array_keys($data);

    $users = \App\Models\User::whereIn('id', $userIds)
        ->get()
        ->keyBy('id');

    $entries = collect($data)->map(function ($score, $userId) use ($users) {

        return (object)[
            'rank' => null, // set below
            'user' => $users[$userId] ?? null,
            'points' => (int) $score,
        ];
    })->values();

    // Assign ranks
    $entries->each(function ($entry, $index) {
        $entry->rank = $index + 1;
    });

    return LeaderboardEntryResource::collection($entries);
}


public function stats(Community $community)
{
    $community->loadCount([
        'members',
        'posts',
        'comments'
    ]);

    // Optional computed metrics
    $community->engagement_score =
        ($community->posts_count * 2) +
        ($community->comments_count);

    $community->active_today = Redis::scard(
        "community:active:{$community->id}:today"
    );

    return new CommunityStatsResource($community);
}







}
