<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use mysql_xdevapi\ColumnResult;
use phpDocumentor\Reflection\Types\String_;
use Rennokki\Befriended\Traits\Follow;
use Rennokki\Befriended\Contracts\Following;

/**
 * @method static where(String $string,  string $string)
 * @method static create(array $array)
 */
class User extends  Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'idt',
        'number '
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function requests()
    {
        return
            [
            $this->hasOne(Requests::class,'sender','id'),
            $this->hasOne(Requests::class,'receiver','id')
            ];
    }

    public function meeting()
    {
        return $this->hasMany(meeting::class,'idCreateMeeting','id');
    }

    public function follower()
    {
        [
            $this->hasMany(Follower::class,'stu_id','id'),
            $this->hasMany(Follower::class,'prof_id','id')
        ];
    }
}
