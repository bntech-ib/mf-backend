<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Post_matric as PostMetric;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Post extends Model
{
    use HasFactory;
    //
   protected $fillable = [
        'user_id',
        'community_id',
        'content',
        'media_url',
        'visibility',
    ];

    /* ===========================
       Author
    ============================*/

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /* ===========================
       Community
    ============================*/

    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
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

    public function reactions(): MorphMany
    {
        return $this->morphMany(Reaction::class, 'reactable');
    }

    /* ===========================
       Metrics (Optimized Counts)
    ============================*/

    public function metrics(): HasOne
    {
        return $this->hasOne(PostMetric::class);
    }

        public function poster()
    {
        return $this->morphTo(name: 'poster');
    }


}
