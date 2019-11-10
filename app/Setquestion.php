<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setquestion extends Model
{
    protected $fillable=['name','price','question_type_id','status'];

    public function question(){
        return $this->hasMany(Question::class);
    }

    public function questionType(){
        return $this->belongsTo(QuestionType::class);
    }

    public function level(){
        return $this->hasMany(Level::class);
    }
}
