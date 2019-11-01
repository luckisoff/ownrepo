<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $fillable=['user_id','sequestion_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function setquestion(){
        return $this->belongsTo(Setquestion::class);
    }

}
