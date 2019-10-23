<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrizeRequest extends FormRequest {
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
			'week_day'      => 'integer|min:1|required',
			// 'position'      => 'integer|min:1|required',
			'sponsor_ids'   => 'array|required',
			'sponsor_ids.*' => 'integer|min:1',
			'prizes'        => 'array|required',
			'prizes.*'      => 'string|required',
		];
	}
}
