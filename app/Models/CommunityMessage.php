<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityMessage extends Model
{
    //

     use HasFactory;

    protected $fillable = [
        'chat_id',
        'user_id',
        'parent_id',
        'content',
        'media_url',
        'is_edited',
    ];

    /* ======================
       Relationships
    ====================== */

    public function chat()
    {
        return $this->belongsTo(CommunityChat::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
