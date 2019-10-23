<?php

namespace App\Http\Requests\Api;

class RegistrationQuizSubmissionRequest extends CommonRequest {
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'questionIds' => 'required|array',
			'answerIds'   => 'required|array',
			'age'         => 'required|integer',
			'gender'      => 'required|string|in:M,F,O',
		];
	}
}
