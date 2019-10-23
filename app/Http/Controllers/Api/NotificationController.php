<?php

namespace App\Http\Controllers\Api;

use App\Device;
use App\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class NotificationController extends CommonController {
	public function index() {
		$notifications = Notification::select('title', 'body', 'created_at')->latest()->get();
		return response()->json([
			'status' => true,
			'code'   => Response::HTTP_OK,
			'data'   => $notifications,
		], Response::HTTP_OK);
	}

	public function saveDeviceToken(Request $request) {
		$validation = $this->my_validation([
			'token' => 'required|string',
			'type'  => ['required', 'max:7', 'in:ios,android'],
		], ['type.in' => 'The type may be ios or android only.']);
		if(!$validation['status']) {
			return response()->json(['status' => false, 'message' => $validation['message']]);
		}

		Device::firstOrCreate([
			'token'   => $request->input('token'),
			'type'    => $request->input('type'),
			'user_id' => auth()->guard('api')->id(),
		]);
		return response()->json([
			'status'  => true,
			'code'    => Response::HTTP_OK,
			'message' => 'Device token saved',
		], Response::HTTP_OK);
	}
}
