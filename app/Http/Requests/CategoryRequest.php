<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest {
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
		// for store() method $category will be null and for update() method it will be an object
		$category = $this->route('category');

		// if it has come from update() method
		if(!is_null($category)) {
			return [
				'name'  => 'required|string|max:255',
				'slug'  => ['required', 'string', 'max:300', Rule::unique('categories')->ignore($category->id)],
				'image' => 'image|max:5120',
				'color' => 'nullable|string|max:7',
			];
		}

		// if it has come from create() method
		return [
			'name.*'  => 'required|string|max:255',
			'slug.*'  => 'required|string|unique:categories,slug|max:300',
			'image.*' => 'image|max:5120',
			'color.*' => 'nullable|string|max:7',
		];
	}
}
