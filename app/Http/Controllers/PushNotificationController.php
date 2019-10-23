<?php

namespace App\Http\Controllers;

use App\Custom\AndroidPushNotification;
use App\Custom\IosPushNotification;
use App\Device;
use Illuminate\Http\Request;

class PushNotificationController extends Controller {
	public function send(Request $request) {
		$devices = Device::select('token')->get();
		$message = [
			'title'   => $request->input('title'),
			'message' => $request->input('message'),
		];

		foreach($devices->chunk(999) as $chunkedDevices) {
			$chunkedDevicesArray = $chunkedDevices->toArray();

			(new AndroidPushNotification($chunkedDevicesArray, $message))->send();
			(new IosPushNotification($chunkedDevicesArray, $message))->send();
		}
	}
}
