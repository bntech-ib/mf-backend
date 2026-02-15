<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommunityResource;
use Illuminate\Http\Request;
use App\Models\Community;

class CommunityController extends Controller
{
    //

    public function index()
    {

    $community = Community::with([
        'owner'
    ])
    ->withCount([
        'members',
        'posts'
    ])
    ->withExists([
        'members as is_member' => fn ($q) =>
            $q->where('user_id', auth()->id())
    ])
    ->findOrFail($id);


    return response()->json([
        "community"=> Community::all(),
    ]);



    }

    public function show(){

    $community = Community::with([
        'owner'
    ])
    ->withCount([
        'members',
        'posts'
    ])
    ->withExists([
        'members as is_member' => fn ($q) =>
            $q->where('user_id', auth()->id())
    ])
    ->findOrFail($id);



    return response()->json([
        'community'=>CommunityResource::collection($community),
    ]);

    }
}
