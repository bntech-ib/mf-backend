<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeasonClub extends Model
{
    //
    
     use HasFactory;

    protected $fillable = [
        'season_id',
        'club_id',
        'league_position',
        'base_allocation',
        'performance_multiplier',
        'final_allocation',
    ];

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

}
