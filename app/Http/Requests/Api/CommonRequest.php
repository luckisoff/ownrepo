<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\Api\ValidationFailed;
use Illuminate\Contracts\Validation\Validator;

abstract class CommonRequest extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}

	/**
	 * @param Validator $validator
	 *
	 * @throws \Exception
	 */
	protected function failedValidation(Validator $validator) {
		$message = collect($validator->errors()->all())->implode('|||');

		throw new ValidationFailed($message);
	}
}
