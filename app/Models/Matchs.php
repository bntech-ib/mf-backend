<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matchs extends Model
{
    //


    
    protected $fillable = [
        'home_club_id',
        'away_club_id',
        'home_score',
        'away_score',
        'kickoff_at',
        'is_finished',
    ];

    protected $casts = [
        'kickoff_at' => 'datetime',
        'is_finished' => 'boolean',
    ];

    public function homeClub()
    {
        return $this->belongsTo(Club::class, 'home_club_id');
    }

    public function awayClub()
    {
        return $this->belongsTo(Club::class, 'away_club_id');
    }

    public function engagements()
    {
        return $this->hasMany(MatchEngagement::class);
    }

    public function predictions()
    {
        return $this->hasMany(MatchPrediction::class);
    }
}
