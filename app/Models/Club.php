<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;  
class Club extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'league',
        'logo',
    ];

    public function homeMatches(): HasMany
    {
        return $this->hasMany(Matchs::class, 'home_club_id');
    }

    public function awayMatches(): HasMany
    {
        return $this->hasMany(Matchs::class, 'away_club_id');
    }

    public function fans(): HasMany
    {
        return $this->hasMany(User::class, 'favorite_club_id');
    }
}

