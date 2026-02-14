<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Reward_log extends Model
{
    use HasFactory;
    //


    protected $fillable = [
    'user_id',
    'action',
    'points',
    'rewardable_id',
    'rewardable_type',
];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function rewardable(): MorphTo
    {
        return $this->morphTo();
    }


}
