<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'difficulty_level_id' => 'nullable|integer|min:1',
			'question_set_id'     => 'nullable|integer|min:1',
			'category_id'         => 'nullable|integer|min:1',
			'question'            => 'required|string|max:255',
			'question_nepali'     => 'required|string|max:255',
			'options'             => 'required|array',
			'options_nepali'      => 'required|array',
			'options.*'           => 'required|string',
			'options_nepali.*'    => 'required|string',
			'answer'              => 'required|integer|min:0',
		];
	}
}
