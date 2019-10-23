<?php

namespace App\Http\Controllers;

use App\Company;

class AsdhController extends Controller {
	protected $website = [];
	protected $default_pagination_limit = 30;

	public function __construct() {
		ini_set('memory_limit', '-1');
		$this->website['company'] = Company::find(1);
	}

	protected function get_array_from_get_request($url) {
		try {
			$ch = curl_init();
			// Disable SSL verification
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			// Will return the response, if false it print the response
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			// Set the url
			curl_setopt($ch, CURLOPT_URL, $url);
			// Execute
			$result = curl_exec($ch);
			// Closing
			curl_close($ch);
			$response = json_decode($result, true);

			return $response;
		} catch(\Exception $e) {
			return response()->json(['status' => false, 'code' => 400, 'message' => 'Login Session Expired.']);
		}
	}
}
