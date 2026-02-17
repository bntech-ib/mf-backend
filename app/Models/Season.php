<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    //
    
        use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'reward_pool',
        'status',
    ];

    public function clubs()
    {
        return $this->hasMany(SeasonClub::class);
    }

    public function loyaltyScores()
    {
        return $this->hasMany(FanLoyaltyScore::class);
    }
}
