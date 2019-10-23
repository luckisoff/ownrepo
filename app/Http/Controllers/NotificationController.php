<?php

namespace App\Http\Controllers;

use App\Custom\PushNotification;
use App\Device;
use App\Notification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class NotificationController extends AsdhController {
	private $viewPath = 'admin.notification';

	public function __construct() {
		parent::__construct();
		$this->website['routeType'] = 'notification';
	}

	public function index() {
		$this->website['models'] = Notification::select('id', 'title', 'body', 'created_at')->latest()->get();

		return view("{$this->viewPath}.index", $this->website);
	}

	public function create() {
		$this->website['edit'] = false;

		return view("{$this->viewPath}.create", $this->website);
	}

	public function store(Request $request) {
		$validData = $request->validate([
			'title' => 'required|string|max:255',
			'body'  => 'required|string|max:255',
		]);

		$this->send($validData);

		return $this->saveToDatabase($validData);
	}

	// this again sends push notification
	public function edit(Notification $notification) {
		$this->send(['title' => $notification->title, 'body' => $notification->body]);

		return redirect()->route($this->website['routeType'] . '.index')->with('success_message', 'Notification sent again.');
	}

	public function destroy(Notification $notification) {
		if($notification->delete()) {
			return back()->with('success_message', 'Notification successfully deleted.');
		}

		return back()->with('failure_message', 'Notification could not be deleted. Please try again later.');
	}

	/**
	 * @param array $validData
	 */
	private function send($validData) {
		/** @var Collection $allDevices */
		$allDevices = Device::select('token')->get();

		/** @var Collection $chunkedDevices */
		foreach($allDevices->chunk(999) as $chunkedDevices) {
			(new PushNotification($chunkedDevices->pluck('token')->toArray(), $validData))->send();
		}
	}

	/**
	 * @param array $validData
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	private function saveToDatabase($validData) {
		return Notification::create($validData)
			? redirect()->route($this->website['routeType'] . '.index')->with('success_message', 'Notification successfully sent.')
			: redirect()->route($this->website['routeType'] . '.index')->with('failure_message', 'Notification could not be sent. Please try again later.');
	}
}
