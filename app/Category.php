<?php

namespace App;

class Category extends Model {
	public function getIconAttribute($value) {
		return !is_null($value)
			? asset($this->image_path . $value)
			: asset($this->image_path . "no-image.jpg");
	}

	public function hasAllDifficultyLevelQuestions() {
		return count(
			       $this->questions()->select('difficulty_level_id')
			            ->pluck('difficulty_level_id')
			            ->unique()->values()
			            ->toArray()
		       ) === 15;
	}

	/* public function getPlayersAttribute($value) {
		return $value * random_int(1, 15);
	} */

	public function customs() {
		return $this->hasMany(Custom::class);
	}

	public function posts() {
		return $this->hasMany(Custom::class)->where('name', 'post');
	}

	public function questions() {
		return $this->hasMany(Question::class);
	}

}
