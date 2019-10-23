<?php

namespace App;

class QuestionSet extends Model {
	protected $dates = ['start_time', 'end_time'];

	public function questions() {
		return $this->hasMany(Question::class);
	}

	public function collections() {
		return $this->belongsToMany(QuestionSetCollection::class, 'collection_question_sets');
	}
}
