<?php

namespace App;

use Illuminate\Support\Facades\Cache;

class FastestFingerFirstQuestion extends Model {
	public function getCachedOptionsAttribute() {
		return Cache::remember($this->cacheKey('options'), $this->defaultCacheDuration, function() {
			return $this->options;
		});
	}

	public function conversions() {
		return $this->hasMany(FastestFingerFirstQuestionConversion::class, 'question_id', 'id');
	}

	public function options() {
		return $this->hasMany(FastestFingerFirstOption::class, 'question_id');
	}

	public function players() {
		return $this->belongsToMany(User::class, 'fastest_finger_first_completion_duration', 'question_id', 'user_id')
		            ->withPivot('duration')
		            ->withTimestamps();
	}

	public function nepali() {
		return $this->conversions->first();
	}
}
