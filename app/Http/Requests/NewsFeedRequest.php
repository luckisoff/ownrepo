<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewsFeedRequest extends FormRequest {
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
		$newsFeed = $this->route('news-feed');
		$slug     = $newsFeed
			? [
				'required',
				'string',
				'max:300',
				Rule::unique('news_feeds')->ignore($newsFeed->id),
			]
			: 'required|string|max:300|unique:news_feeds';

		return [
			'title'       => 'required|string|max:255',
			'slug'        => $slug,
			'description' => 'nullable|string',
			'url'         => 'nullable|url',
			'type'        => 'nullable|string',
			'image'       => 'nullable|image|max:5120',
		];
	}
}
