<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {
		Schema::defaultStringLength(191);
		Validator::extend('recaptcha', function($attribute, $value, $parameters, $validator) {
			$url = "https://www.google.com/recaptcha/api/siteverify?secret=6LeACygUAAAAAMPG9TJkm4T81bC3xAr3ioH_0hPC&response=" . $value . "&remoteip=" . $_SERVER['REMOTE_ADDR'];
			//  Initiate curl
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

			return $response['success'];
		});

		// add this below line in html:
		// <div class="g-recaptcha" data-sitekey="6LeACygUAAAAAGUd34FU1TCJuXyyzYq6Onr7Zi5D"></div>

		/*DB::listen(function ($query) {
			Log::info($query->sql);
		});*/
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() {
		//
	}
}
