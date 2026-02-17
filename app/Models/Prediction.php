<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prediction extends Model
{
    //
    protected $fillable = [
        'user_id',
        'match_id',
        'home_score_predicted',
        'away_score_predicted',
        'points_awarded',
        'is_scored',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function match()
    {
        return $this->belongsTo(Matchs::class);
    }
}
