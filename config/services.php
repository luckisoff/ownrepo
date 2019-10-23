<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Third Party Services
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Stripe, Mailgun, SparkPost and others. This file provides a sane
	| default location for this type of information, allowing packages
	| to have a conventional place to find your various credentials.
	|
	*/

	'mailgun' => [
		'domain' => env('MAILGUN_DOMAIN'),
		'secret' => env('MAILGUN_SECRET'),
	],

	'ses' => [
		'key'    => env('SES_KEY'),
		'secret' => env('SES_SECRET'),
		'region' => 'us-east-1',
	],

	'sparkpost' => [
		'secret' => env('SPARKPOST_SECRET'),
	],

	'stripe' => [
		'model'  => App\User::class,
		'key'    => env('STRIPE_KEY'),
		'secret' => env('STRIPE_SECRET'),
	],

	'passport' => [
		'client_1_secret' => env('PASSPORT_CLIENT_1_SECRET'),
		'client_2_secret' => env('PASSPORT_CLIENT_2_SECRET'),
	],

	'khalti' => [
		'test_secret_key' => env('KHALTI_TEST_SECRET_KEY'),
		'live_secret_key' => env('KHALTI_LIVE_SECRET_KEY'),
	],

	'facebook' => [
		'client_id'     => env('FACEBOOK_ID'),
		'client_secret' => env('FACEBOOK_SECRET'),
		'redirect'      => env('FACEBOOK_REDIRECT_URL'),
	],

	'google' => [
		'client_id'     => env('GOOGLE_ID'),
		'client_secret' => env('GOOGLE_SECRET'),
		'redirect'      => env('GOOGLE_REDIRECT_URL'),
	],

	'recaptcha' => [
		'secret' => env('RECAPTCHA_SECRET'),
		'public' => env('RECAPTCHA_PUBLIC'),
	],

];
