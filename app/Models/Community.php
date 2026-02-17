<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Community extends Model
{
    use HasFactory;
    //

    protected $fillable = [
        'name',
        'slug',
        'description',
        'owner_id',
        'privacy',
    ];

public function owner()
{
    return $this->belongsTo(User::class, 'owner_id');
}


public function members()
{
    return $this->belongsToMany(User::class, 'community_members')
        ->withPivot('role')
        ->withTimestamps();
}

public function posts()
{
    return $this->morphMany(Post::class, 'poster');
}

public function comments()
{
    return $this->hasManyThrough(
        Comment::class,
        Post::class,
        'poster_id',
        'post_id'
    )->where('poster_type', self::class);
}



public function chat()
{
    return $this->morphOne(Chat::class, 'chatable');
}


}
