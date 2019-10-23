<?php

namespace App;

class Option extends Model {
	public function question() {
		return $this->belongsTo(Question::class);
	}

	public function conversions() {
		return $this->hasMany(OptionConversion::class);
	}

	public function nepali() {
		return $this->conversions->first();
	}

	public function is_answer() {
		return $this->answer == 1;
	}
}
