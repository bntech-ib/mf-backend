<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Events\PostCreated;
use App\Events\PostLiked;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PostResource;


class PostController extends Controller
{
    //


    public function index(Request $request){
        $post =Post::latest()
    ->paginate(10);
        // $score = (likes * 2) + (comments * 3) - hours_since_post;
        return response()->json([   
            'post'=> $post ,
            ]);
 
    }

 
    public function store(Request $request){

     $post = Post::create([
        'user_id' => auth::user()->id,
        'content' => $request->input('content'),
    ]);

    PostCreated::dispatch($post); 
    return response()->json(['message' => 'Post created']);

    }

    public function show($id){
        
    }

    public function edit($id){

    }

    public function update(Request $request, $id){

    }

    public function destroy($id){

    }

    public function like(Post $id){  

    PostLiked::dispatch($id);



    }
}
