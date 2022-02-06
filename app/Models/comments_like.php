<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comments_like extends Model
{
    use HasFactory;
    protected $table = 'comments_like';

    protected $fillable = ["comment_id"];
    public function Comment()
    {
        return $this->belongsTo('App\Models\Comment', 'comment_id', 'id');
    }
    public function User()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
