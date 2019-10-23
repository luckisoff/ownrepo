<?php

namespace App\Custom;

use App\Interfaces\PushNotificationInterface;

class AndroidPushNotification implements PushNotificationInterface {
	/**
	 * Firebase instance tokens
	 *
	 * @var array
	 */
	public $deviceTokens = [];

	/**
	 * keys of message must be 'title' and 'body'
	 *
	 * @var array
	 */
	public $message = [];

	/**
	 * Initialize Devices and tokens
	 *
	 * @param array $deviceTokens
	 * @param array $message
	 */
	public function __construct($deviceTokens = [], $message = []) {
		$this->deviceTokens = $deviceTokens;
		$this->message      = array_add($message, 'sound', 'default');
	}

	/**
	 * Send push notification
	 *
	 * @return mixed
	 */
	public function send() {
		$url     = 'https://fcm.googleapis.com/fcm/send';
		$fields  = [
			'registration_ids' => $this->deviceTokens,
			'notification'     => $this->message,
		];
		$headers = [
			"Authorization:key = " . env('ANDROID_SERVER_KEY'),
			"Content-Type: application/json",
		];
		$ch      = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		$response = curl_exec($ch);
		if($response === false) {
			die('Curl failed: ' . curl_error($ch));
		}
		curl_close($ch);

		return $response;
	}
}