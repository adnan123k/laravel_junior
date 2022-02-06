<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $table = 'videos';
    protected $fillable = [
        'title',
        'description',
        'url',
        'full_name',
        'lesson_id'
    ];

    public function Discussion()
    {
        return $this->hasMany('App\Models\Discussion', 'video_id', 'id');
    }
    public function Lesson()
    {
        return $this->belongsTo('App\Models\Lesson', 'lesson_id', 'id');
    }
    public function User()
    {
        return $this->belongsTo('App\Models\User', 'teacher_id', 'id');
    }
}
