<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $fillable = [
        'body', 'discussion_id'
    ];

    public function Comment_likes()
    {
        return $this->hasMany('App\Models\comments_like', 'comment_id', 'id');
    }
    public function Discussion()
    {
        return $this->belongsTo('App\Models\Discussion', 'discussion_id', 'id');
    }
    public function User()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
