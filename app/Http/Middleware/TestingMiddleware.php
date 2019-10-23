<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;

class TestingMiddleware {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 *
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		/*if(Carbon::now()->greaterThan(Carbon::parse('2018-12-25 00:00:00'))) {
			return response()->json(['status' => true, 'data' => []]);
		}*/

		return $next($request);
	}
}
