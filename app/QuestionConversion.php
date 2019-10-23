<?php

namespace App;

class QuestionConversion extends Model {
	public function question() {
		return $this->belongsTo(Question::class);
	}
}
