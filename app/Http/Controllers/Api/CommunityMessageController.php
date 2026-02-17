<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommunityMessageResource;
use App\Models\CommunityChat;
use App\Models\CommunityMessage;
use Illuminate\Http\Request;

class CommunityMessageController extends Controller
{
    //
    public function index(CommunityChat $chat)
{
    $messages = CommunityMessage::where('chat_id', $chat->id)
        ->with('sender')
        ->latest()
        ->cursorPaginate(30);

    return CommunityMessageResource::collection($messages);
}
 


public function store(Request $request, CommunityChat $chat ) {
   

$data = $request->validate([
        'content' => ['nullable', 'string'],
        'media_url' => ['nullable', 'url'],
        'parent_id' => ['nullable', 'exists:community_messages,id'],
    ]);

    if (! $data['content'] && ! $data['media_url']) {
        return response()->json([
            'message' => 'Message cannot be empty.'
        ], 422);
    }

    $message = CommunityMessage::create([
        'chat_id'   => $chat->id,
        'user_id'   => $request->user()->id,
        'parent_id' => $data['parent_id'] ?? null,
        'content'   => $data['content'] ?? null,
        'media_url' => $data['media_url'] ?? null,
    ]);

    $message->load('sender');

    return new CommunityMessageResource($message);
}

public function destroy(CommunityMessage $message)
{ 

    $message->delete();

    return response()->json([
        'message' => 'Message deleted.'
    ]);
}

}
