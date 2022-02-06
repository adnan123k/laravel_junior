<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $table = 'subjects';
    protected $fillable = ["title"];
    public function Lesson()
    {
        return $this->hasMany('App\Models\Lesson', 'subject_id', 'id');
    }
    public function Level()
    {
        return $this->hasMany('App\Models\Level', 'subject_id', 'id');
    }
    public function User_level()
    {
        return $this->hasMany('App\Models\User_level', 'subject_id', 'id');
    }
}
