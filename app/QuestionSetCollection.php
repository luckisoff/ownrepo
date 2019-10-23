<?php

namespace App;

class QuestionSetCollection extends Model {
	protected $dates = ['show_on'];

	public function question_sets() {
		return $this->belongsToMany(QuestionSet::class, 'collection_question_sets');
	}

	public function has_question_set(QuestionSet $questionSet) {
		foreach($this->question_sets as $question_set) {
			if($question_set->id == $questionSet->id) {
				return true;
			}
		}

		return false;
	}
}
