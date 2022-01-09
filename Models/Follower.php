<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    use HasFactory;

    public function user()
    {
        [
            $this->belongsTo(User::class, 'stu_id','id'),
            $this->belongsTo(User::class,'prof_id','id')
        ];
    }

    public function meeting()
    {
        return $this->hasMany(meeting::class,'id_follower','id');

    }
}
