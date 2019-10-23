<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Recaptcha implements Rule {
	/**
	 * Create a new rule instance.
	 *
	 * @return void
	 */
	public function __construct() {
		//
	}

	/**
	 * Determine if the validation rule passes.
	 *
	 * @param  string $attribute
	 * @param  mixed $value
	 *
	 * @return bool
	 */
	public function passes($attribute, $value) {
		$secret_key = config('services.recaptcha.secret');
		$url        = 'https://www.google.com/recaptcha/api/siteverify';
		$response   = $this->get_array_from_post_request($url, [
			'secret'   => $secret_key,
			'response' => $value,
			'remoteip' => $_SERVER['REMOTE_ADDR'],
		]);

		return $response['success'];
		// add this below line in html:
		// <script src='https://www.google.com/recaptcha/api.js'></script>
		// <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.public') }}"></div>
	}

	/**
	 * Get the validation error message.
	 *
	 * @return string
	 */
	public function message() {
		return 'Please click on "I am not a robot" and try again.';
	}

	private function get_array_from_post_request($url, $parameters = []) {
		try {
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
			$result = curl_exec($ch);
			curl_close($ch);
			$response = json_decode($result, true);

			return $response;
		} catch(\Exception $e) {
			return back()->with('failure_message', 'Invalid Request');
		}
	}
}
