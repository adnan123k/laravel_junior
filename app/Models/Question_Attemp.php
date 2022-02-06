<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question_Attemp extends Model
{
    use HasFactory;
    protected $fillable = ['question_id', 'user_id', 'passed'];
    public function Question()
    {
        return $this->belongsTo('App\Models\Question', 'question_id', 'id');
    }
    public function User()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
