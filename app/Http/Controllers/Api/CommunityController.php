<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Community;

class CommunityController extends Controller
{
    //

    public function index()
    {


    return response()->json([
        "community"=> Community::all(),
    ]);



    }
}
