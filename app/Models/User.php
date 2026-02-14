<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\Reward_log as RewardLog;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }




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

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

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

    public function communities(): BelongsToMany
    {
        return $this->belongsToMany(
            Community::class,
            'community_members'
        )->withPivot('role')
         ->withTimestamps();
    }

    /* ===========================
       Rewards
    ============================*/

    public function rewardLogs(): HasMany
    {
        return $this->hasMany(RewardLog::class);
    }

}
