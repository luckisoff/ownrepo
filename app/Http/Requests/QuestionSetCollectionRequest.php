<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionSetCollectionRequest extends FormRequest {
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
			'sponser_image' => 'image|max:5120',
			'icon'          => 'image|max:5120',
			'color'         => 'nullable|string|max:7',
			'show_on'       => 'required|date_format:m/d/Y',
		];
	}

	public function messages() {
		return [
			'show_on.date_format' => 'Date format is not correct. (Eg. 09/21/2017)',
		];
	}
}
