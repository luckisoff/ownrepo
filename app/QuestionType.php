<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionType extends Model
{
    protected $fillable=['name','point'];

    public function question(){
        return $this->hasMany(Question::class);
    }

    public function setquestion(){
        return $this->hasMany(Setquestion::class);
    }
}
