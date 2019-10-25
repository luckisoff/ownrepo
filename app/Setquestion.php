<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setquestion extends Model
{
    protected $fillable=['name','price','question_type_id','status'];

    public function question(){
        return $this->hasMany(Question::class);
    }

    public function questiontype(){
        return $this->belongsTo(QuestionType::class);
    }
}
