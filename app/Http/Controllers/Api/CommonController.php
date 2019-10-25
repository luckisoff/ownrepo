<?php

namespace App\Http\Controllers\Api;

use App\User;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CommonController extends Controller {
	public function __construct() {
		ini_set('memory_limit', '-1');
	}

	public function test(){
		return 'test';
	}
	protected function my_validation($validation, $messages = []) {
		$validator = Validator::make(request()->all(), $validation, $messages);
		if($validator->fails()) {
			return ['status' => false, 'message' => $validator->errors()->all()];
		}

		return ['status' => true];
	}

	protected function get_week_day() {
		// the day when quiz starts
		$quiz_start_date = Carbon::parse('2018-02-14');

		// shift the quiz start day to sunday of that week
		$modified_quiz_start_day = $quiz_start_date->subDays($quiz_start_date->dayOfWeek);

		// today
		$today = Carbon::today();


		// today - quiz start day
		$total_days_of_quiz = $today->diffInDays($modified_quiz_start_day, true);
		// total_days_of_quiz divided by seven gives quotient less than seven
		// the quotient may be float, so i floored it and made int
		// for first week it is 0
		// for second week it is 1
		// so i added 1 to start week from 1
		return (int)floor($total_days_of_quiz / 7) + 1;
	}

	/**
	 * Get list of tokens generated for the user after registration
	 *
	 * @param null $user
	 *
	 * @return array
	 */
	protected function get_registration_token_list($user = null): array {
		/** @var User $user */
		$user = $user ?? auth()->guard('api')->user();

		return $user->registration_participation()
		            ->latest()
		            ->get()
		            ->groupBy(function($registration) {
			            return $registration->created_at->format('Y-m-d');
		            })
		            ->map(function($registrations, $key) {
			            return [
				            'date'   => Carbon::parse($key)->format('d F Y'),
				            'tokens' => $registrations->map(function($registration) {
					            return [
						            'token'      => $registration->token,
						            'created_at' => $registration->created_at->format('H:I A'),
					            ];
				            }),
			            ];
		            })
		            ->values()
		            ->toArray();
	}
}
