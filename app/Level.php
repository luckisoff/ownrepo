<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $fillable=['user_id','sequestion_id'];

    public function setquestion(){
        return $this->belongsTo(Setquestion::class);
    }

}
