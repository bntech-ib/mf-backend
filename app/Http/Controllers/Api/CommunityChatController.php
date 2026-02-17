<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommunityChatResource;
use App\Models\Community;
use App\Models\CommunityChat;
use Illuminate\Http\Request;

class CommunityChatController extends Controller
{
    //


    public function store(
    Request $request,
    Community $community
) {
    $data = $request->validate([
        'name' => ['required', 'string', 'max:100'],
        'type' => ['nullable', 'in:general,match,announcement,private'],
        'is_private' => ['boolean'],
    ]);

    $chat = CommunityChat::create([
        'community_id' => $community->id,
        'created_by'   => $request->user()->id,
        'name'         => $data['name'],
        'type'         => $data['type'] ?? 'general',
        'is_private'   => $data['is_private'] ?? false,
    ]);

    $chat->load('creator');

    return new CommunityChatResource($chat);
}
}
