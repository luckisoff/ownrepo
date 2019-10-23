<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Question;
class Setquestion extends Model
{
    protected $fillable=['name'];

    public function Question(){
        return $this->hasMany(Question::class);
    }
}
