<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setquestion extends Model
{
    protected $fillable=['name','price','status'];

    public function question(){
        return $this->hasMany(Question::class);
    }
}
