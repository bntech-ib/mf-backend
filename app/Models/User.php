<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; 
use App\Models\Reward_log as RewardLog;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password', 
        'avatar',
        'points',
    ];

    /* ===========================
       Followers System
    ============================*/

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'followers',
            'following_id',
            'follower_id'
        )->withTimestamps();
    }

    public function following(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'followers',
            'follower_id',
            'following_id'
        )->withTimestamps();
    }

    /* ===========================
       Posts
    ============================*/
 

    /* ===========================
       Comments
    ============================*/

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /* ===========================
       Reactions
    ============================*/

    public function reactions(): HasMany
    {
        return $this->hasMany(Reaction::class);
    }

    /* ===========================
       Communities
    ============================*/

    public function ownedCommunities(): HasMany
    {
        return $this->hasMany(Community::class, 'owner_id');
    }

public function predictions()
{
    return $this->hasMany(Prediction::class);
}

public function communities()
{
    return $this->belongsToMany(
        Community::class,
        'community_members'
    )->withPivot('role');
}

public function badges()
{
    return $this->belongsToMany(
        Badge::class,
        'user_badges'
    )->withTimestamps();
}

    /* ===========================
       Rewards
    ============================*/

    public function rewardLogs(): HasMany
    {
        return $this->hasMany(RewardLog::class);
    }
    public function posts()
{
    return $this->morphMany(Post::class, 'poster');
}

public function clubs()
{
    return $this->belongsToMany(
        Club::class,
        'fan_clubs'
    )->withPivot([
        'loyalty_score',
        'is_primary',
        'joined_at'
    ]);
}

public function createdChats()
{
    return $this->hasMany(
        CommunityChat::class,
        'created_by'
    );
}
public function favoriteClub()
{
    return $this->belongsTo(Club::class, 'favorite_club_id');
}
}
