<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdsRequest extends FormRequest {
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
		$model = optional($this->route('ad'));

		return [
			'title'       => 'required|string|max:255',
			'slug'        => [
				'required',
				'string',
				'max:255',
				Rule::unique('ads')->ignore($model->id),
			],
			'image'       => 'nullable|image|max:5120',
			'description' => 'required|string',
			'contact'     => 'required|string|max:50',
			'email'       => 'required|string|max:50',
		];
	}
}
