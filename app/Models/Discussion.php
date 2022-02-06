<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    use HasFactory;
    protected $table = 'discussions';
    protected $fillable = [
        'body', 'video_id'
    ];
    public function Discussion_likes()
    {
        return $this->hasMany('App\Models\discussion_like', 'discussion_id', 'id');
    }
    public function Comment()
    {
        return $this->hasMany('App\Models\Comment', 'discussion_id', 'id');
    }
    public function Video()
    {
        return $this->belongsTo('App\Models\Video', 'video_id', 'id');
    }
    public function User()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
