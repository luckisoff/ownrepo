<?php

namespace App\Http\Controllers;

use App\RegistrationParticipation;
use App\User;
use Illuminate\Http\Request;

class KbcRegistrationController extends AsdhController {
	public function __construct() {
		parent::__construct();
	}

	public function selectUserRandomly(Request $request) {
		$selectedUserIds                = RegistrationParticipation::where('selected', 1)->pluck('user_id')->unique()->values()->toArray();
		$this->website['selectedUsers'] = User::select('id', 'name', 'email', 'gender', 'age')->find($selectedUserIds);

		// show view to select user randomly
		if(!$request->has('selected')) {
			return view('admin.registration.selection', $this->website);
		}

		// get a random row from previously unselected user
		$selectedRow = RegistrationParticipation::notSelected()->inRandomOrder()->first();

		if(!$selectedRow) {
			return back()->with('failure_message', 'No participants.');
		}

		// make row with user id selected
		RegistrationParticipation::where('user_id', $selectedRow->user_id)->update([
			'selected'    => 1,
			'selected_at' => now()->toDateTimeString(),
		]);
		$this->website['selectedUser'] = User::find($selectedRow->user_id);

		return view('admin.registration.selection', $this->website);
	}
}
