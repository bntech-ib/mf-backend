<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FanSeasonStat extends Model
{
    //

        use HasFactory;

    protected $fillable = [
        'user_id',
        'club_id',
        'matches_engaged',
        'content_posts',
        'comments_made',
        'total_points',
        'tier',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function club()
    {
        return $this->belongsTo(Club::class);
    }
}
