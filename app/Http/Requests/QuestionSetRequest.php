<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionSetRequest extends FormRequest {
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
			'title'         => 'required|string|max:255',
			'color'         => 'nullable|string|max:7',
			'sponser_image' => 'nullable|image|max:5120',
			'icon'          => 'nullable|image|max:5120',
			'start_time'    => 'required',
			'end_time'      => 'required',
		];
	}
}
