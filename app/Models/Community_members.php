<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Community_members extends Model
{
    use HasFactory;
    //


protected $fillable = [
    'community_id',
    'user_id',
    'role',
];


    public function users(){
        return $this->belongsToMany(User::class);
    }
    public function tasks(){


    return $this->hasMany(Task::class);
    }
}
