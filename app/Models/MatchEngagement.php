<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class MatchEngagement extends Model
{
       use HasFactory;

    protected $fillable = [
        'match_id',
        'user_id',
        'predicted',
        'commented',
        'shared',
    ];

    protected $casts = [
        'predicted' => 'boolean',
        'commented' => 'boolean',
        'shared' => 'boolean',
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
