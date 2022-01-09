<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class meeting extends Model
{
    use HasFactory;

    protected $fillable=
        [
        'title',
        'location',
        'status',
        'doc',
        'time',
    ];

    public function users()
    {
        return $this->belongsTo(User::class,'idCreateMeeting','id');
    }

    public function follower()
    {
        return $this->belongsTo(Follower::class,'id_follower','id');
    }
}
