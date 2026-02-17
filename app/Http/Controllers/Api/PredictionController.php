<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PredictionResource;
use App\Models\Matchs;
use App\Models\Prediction;
use Illuminate\Http\Request;

class PredictionController extends Controller
{
    //
public function myPredictions(Request $request)
{
    $predictions = $request->user()
        ->predictions()
        ->with('match')
        ->latest()
        ->paginate(20);

    return PredictionResource::collection($predictions);
}
    public function store(Request $request, Matchs $match)
{
    // ❌ Cannot predict after kickoff
    if (now()->gte($match->kickoff_at)) {
        return response()->json([
            'message' => 'Prediction closed.'
        ], 422);
    }

    $data = $request->validate([
        'home_score' => ['required', 'integer', 'min:0'],
        'away_score' => ['required', 'integer', 'min:0'],
    ]);

    $prediction = Prediction::updateOrCreate(
        [
            'user_id' => $request->user()->id,
            'match_id' => $match->id,
        ],
        [
            'home_score_predicted' => $data['home_score'],
            'away_score_predicted' => $data['away_score'],
        ]
    );

    return response()->json([
        'message' => 'Prediction saved.',
        'prediction' => $prediction
    ]);
}

}
