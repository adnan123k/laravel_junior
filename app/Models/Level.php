<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'subject_id','lesson_id'];
    public function User_level()
    {
        return $this->hasMany('App\Models\User_level', 'level_id', 'id');
    }
    public function Question()
    {
        return $this->hasMany('App\Models\Question', 'level_id', 'id');
    }
    public function Subject()
    {
        return $this->belongsTo('App\Models\Subject', 'subject_id', 'id');
    }
}
