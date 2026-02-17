<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BadgeResource;
use App\Http\Resources\ClubResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\PredictionResource;
use App\Http\Resources\UserProfileResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
 public function me(Request $request)
    {
        $user = $request->user();

        $user->load('favoriteClub')
            ->loadCount([
                'posts',
                'followers',
                'following',
                'predictions',
            ]);

        return new UserResource($user);
    }

    /**
     * Public profile
     * GET /users/{user}
     */
public function show(User $user)
{
    $authId = Auth::user()->id;

    $user->load('favoriteClub')
        ->loadCount([
            'posts',
            'followers',
            'following',
            'predictions',
        ])
        ->loadExists([
            'followers as is_followed' => function ($q) use ($authId) {
                if ($authId) {
                    $q->where('follower_id', $authId);
                } else {
                    $q->whereRaw('false');
                }
            }
        ]);

    return new UserResource($user);
}

    public function posts(User $user)
{
    $posts = $user->posts()
        ->with('poster')
        ->withCount([
            'reactions as likes_count' => fn ($q) =>
                $q->where('type', 'like'),
            'comments'
        ])
        ->withExists([
            'reactions as is_liked' => fn ($q) =>
                Auth::check()
                    ? $q->where('type', 'like')
                        ->where('user_id',  Auth::user()->id)
                    : $q->whereRaw('false')
        ])
        ->latest()
        ->cursorPaginate(15);

    return PostResource::collection($posts);
}

public function badges(User $user)
{
    return BadgeResource::collection(
        $user->badges()->latest()->get()
    );
}
 
public function clubs(User $user)
{
    return ClubResource::collection(
        $user->clubs()
            ->withPivot(['loyalty_score', 'is_primary'])
            ->get()
    );
}
public function followers(User $user)
{
    $followers = $user->followers()
        ->latest('followers.created_at')
        ->paginate(30);

    return UserResource::collection($followers);
}

public function following(User $user)
{
    $following = $user->following()
        ->latest('followers.created_at')
        ->paginate(30);

    return UserResource::collection($following);
}
public function userPredictions(User $user)
{
    $predictions = $user->predictions()
        ->with('match')
        ->latest()
        ->paginate(20);

    return PredictionResource::collection($predictions);
}













public function update(Request $request)
{
    $user = $request->user();

    $data = $request->validate([
        'name' => ['sometimes', 'string', 'max:255'],
        'username' => [
            'sometimes',
            'string',
            'max:20',
            "unique:users,username,{$user->id}"
        ],
        'bio' => ['nullable', 'string', 'max:100'],
        'avatar' => ['nullable', 'url'],
        'favorite_club_id' => ['nullable', 'exists:clubs,id'],
    ]);

    $user->update($data);

    return new UserResource($user->fresh());
}

}
