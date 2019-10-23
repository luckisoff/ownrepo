<?php

namespace App\Http\Controllers\Api;

use App\Prize;
use Illuminate\Http\Request;

class PrizeController extends CommonController {
	public function index() {
		$weekDay = $this->get_week_day();
		$prizes  = Prize::with('sponsor')->where('week_day', $weekDay)
		                ->select('sponsor_id', 'description')
		                ->get();

		if(!$prizes->count()) {
			return response()->json(['status' => false, 'message' => 'No prizes this week']);
		}

		return response()->json(['status' => true, 'data' => $prizes]);

	}
}
