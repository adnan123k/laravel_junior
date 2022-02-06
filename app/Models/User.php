<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'username',
        'points',
        'role',
        'mother_name',
        'father_name',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',

    ];
    public function Comment_likes()
    {
        return $this->hasMany('App\Models\comments_like', 'user_id', 'id');
    }
    public function Discussion_likes()
    {
        return $this->hasMany('App\Models\discussion_like', 'user_id', 'id');
    }
    public function User_level()
    {
        return $this->hasMany('App\Models\User_level', 'user_id', 'id');
    }
    public function Question_attemp()
    {
        return $this->hasMany('App\Models\Question_Attemp', 'user_id', 'id');
    }
    public function Discussion()
    {
        return $this->hasMany('App\Models\Discussion', 'user_id', 'id');
    }
    public function Comment()
    {
        return $this->hasMany('App\Models\Comment', 'user_id', 'id');
    }
    public function Video()
    {
        return $this->hasMany('App\Models\Video', 'teacher_id', 'id');
    }
}
