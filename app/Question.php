<?php

namespace App;

class Question extends Model {
	public function getFileAttribute($value) {
		return asset("public/files/{$value}");
	}

	public function options() {
		return $this->hasMany(Option::class);
	}

	public function conversions() {
		return $this->hasMany(QuestionConversion::class);
	}

	public function difficulty_level() {
		return $this->belongsTo(DifficultyLevel::class);
	}

	public function category() {
		return $this->belongsTo(Category::class);
	}

	public function nepali() {
		return $this->conversions->first();
	}

	public function options_nepali() {
		$options_nepali = [];
		foreach($this->options->shuffle() as $option) {
			$options_nepali[] = [
				'name'   => optional($option->nepali())->name,
				'answer' => $option->answer,
			];
		}

		return $options_nepali;
	}

	public function question_set() {
		return $this->belongsTo(QuestionSet::class);
	}

	public function options_nepali_without_answer() {
		$options_nepali = [];
		foreach($this->options->shuffle() as $option) {
			$options_nepali[] = [
				'id'   => $option->id,
				'name' => optional($option->nepali())->name,
				// 'answer' => $option->answer,
			];
		}

		return $options_nepali;
	}

	public function scopeOnline($query) {
		return $query->where('online', 1);
	}

	public function scopeOffline($query) {
		return $query->where('online', 0);
	}
}
