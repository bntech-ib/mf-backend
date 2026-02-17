<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class FollowController extends Controller
{
    //


    public function follow(User $user, Request $request)
{
    $auth = $request->user();

    if ($auth->id === $user->id) {
        return response()->json([
            'message' => 'Cannot follow yourself.'
        ], 422);
    }

    $auth->following()->syncWithoutDetaching($user->id);

    return response()->json([
        'message' => 'User followed.'
    ]);
}

public function unfollow(User $user, Request $request)
{
    $auth = $request->user();

    $auth->following()->detach($user->id);

    return response()->json([
        'message' => 'User unfollowed.'
    ]);
}


public function status(User $user, Request $request)
{
    return response()->json([
        'is_following' => $request->user()
            ->following()
            ->where('following_id', $user->id)
            ->exists()
    ]);
}


}
