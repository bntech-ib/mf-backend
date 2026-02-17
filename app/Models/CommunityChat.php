<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityChat extends Model
{
  use HasFactory;

    protected $fillable = [
        'community_id',
        'created_by',
        'name',
        'type',
        'is_private',
        'position',
        'last_message_at',
    ];

    /* ======================
       Relationships
    ====================== */

    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function messages()
    {
        return $this->hasMany(
            CommunityMessage::class,
            'chat_id'
        );
    }

}
