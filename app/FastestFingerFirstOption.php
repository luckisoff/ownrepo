<?php

namespace App;

class FastestFingerFirstOption extends Model {
	protected $touches = ['question'];

	public function question() {
		return $this->belongsTo(FastestFingerFirstQuestion::class, 'question_id');
	}

	public function conversions() {
		return $this->hasMany(FastestFingerFirstOptionConversion::class, 'option_id', 'id');
	}

	public function nepali() {
		return $this->conversions->first();
	}
}
