<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_level extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'level_id', 'subject_id'];
    public function Subject()
    {
        return $this->belongsTo('App\Models\Subject', 'subject_id', 'id');
    }
    public function Level()
    {
        return $this->belongsTo('App\Models\Level', 'level_id', 'id');
    }
    public function User()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
