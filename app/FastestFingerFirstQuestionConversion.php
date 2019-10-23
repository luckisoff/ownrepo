<?php

namespace App;

class FastestFingerFirstQuestionConversion extends Model {
	public function question() {
		return $this->belongsTo(FastestFingerFirstQuestion::class, 'question_id', 'id');
	}
}
