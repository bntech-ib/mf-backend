<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


use Illuminate\Database\Eloquent\Model;

class Post_matric extends Model
{
    use HasFactory;
    //

     protected $fillable = [
        'post_id',
        'likes_count',
        'comments_count',
        'shares_count',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }


}
