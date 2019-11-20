<?php

namespace App\Http\Controllers;

use App\Setting;
use App\Subscriber;
use App\User;
use Carbon\Carbon;

class AdminController extends AsdhController {
	public function __construct() {
		parent::__construct();
	}

	public function index() {
	    \Artisan::call('migrate');
		$this->website['total_users'] = User::count();

		$this->website['weeklyWinners'] = $a = $this->getWeeklyWinners();
		// $this->website['weeklyWinners'] = $a = [];

		$this->website['settings'] = Setting::first() ?? new Setting(['notice_status' => false, 'notice_title' => '', 'notice_message' => '']);

		// $this->website['weeklyWinners'] = [];
//        dd($this->website);
		return view('admin.index', $this->website);
	}

	public function subscribers() {
		$this->website['routeType']   = 'subscriber';
		$this->website['subscribers'] = Subscriber::latest()->paginate($this->default_pagination_limit);

		return view('admin.subscriber.index', $this->website);
	}

	private function getWeeklyWinners() {
		$weekDay       = $this->getWeekDay();
		$limit         = 20;
		$weeklyWinners = [];

		for($i = $weekDay; $i >= ($weekDay - 1); $i --) {
			$url                 = "http://kbcnepal.com/api/get-leaderboard-points3?week_day={$i}&data_limit={$limit}";
			$winners             = $this->get_array_from_get_request($url);
			$weeklyWinners[ $i ] = $winners['data'];
		}

		return $weeklyWinners;
	}

	private function getWeekDay() {
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

}
