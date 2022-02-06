<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = ['question', 'point', 'choice', 'answer', 'level_id', 'lesson_id'];
    protected $casts = [
        'choice' => 'array'
    ];
    public function User_attemp()
    {
        return $this->hasMany('App\Models\Question_Attemp', 'question_id', 'id');
    }
    public function Question()
    {
        return $this->belongsTo('App\Models\Question', 'question_id', 'id');
    }
    public function Lesson()
    {
        return $this->belongsTo('App\Models\Lesson', 'lesson_id', 'id');
    }
}
