<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;
    protected $table = 'lessons';
    protected $fillable = ["title", 'subject_id'];

    public function Video()
    {
        return $this->hasMany('App\Models\Video', 'lesson_id', 'id');
    }
    public function Question()
    {
        return $this->hasMany('App\Models\Question', 'lesson_id', 'id');
    }
    public function Subject()
    {
        return $this->belongsTo('App\Models\Subject', 'subject_id', 'id');
    }
}
