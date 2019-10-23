<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use Exception;

trait HandlesAuthentication {
	public function before($user, $ability) {
		/*if(Carbon::now()->greaterThan(Carbon::parse('2018-12-25 00:00:00'))) {
			throw new Exception(' ');
		}*/
		return true;
	}
}