<?php

namespace App;

class DifficultyLevel extends Model {
	public function questions() {
		return $this->hasMany(Question::class);
	}
}
