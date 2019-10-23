<?php

namespace App\Http\Requests\Api;

class QuestionSetQuizSubmissionRequest extends CommonRequest {
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'questionIds' => 'required|array',
			'answerIds'   => 'required|array',
		];
	}
}
