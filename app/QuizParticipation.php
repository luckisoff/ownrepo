<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizParticipation extends Model {
	protected $guarded = ['id'];
	protected $dates = ['selected_at'];
}
