<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatchPrediction extends Model
{
    //

      use HasFactory;

    protected $fillable = [
        'match_id',
        'user_id',
        'home_score_predicted',
        'away_score_predicted',
        'points_awarded',
    ];

    protected $casts = [
        'points_awarded' => 'integer',
    ];

    public function match()
    {
        return $this->belongsTo(Matchs::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
