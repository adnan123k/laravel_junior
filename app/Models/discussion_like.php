<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class discussion_like extends Model
{
    use HasFactory;
    protected $table = 'discussion_like';
    protected $fillable = ["discussion_id"];

    public function Discussion()
    {
        return $this->belongsTo('App\Models\Discussion', 'discussion_id', 'id');
    }
    public function User()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
