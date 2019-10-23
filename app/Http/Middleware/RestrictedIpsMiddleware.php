<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class RestrictedIpsMiddleware {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure                 $next
	 *
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		$restrictedIps    = [
			'124.41.211.143',
			'27.34.20.86',
		];
		$restrictedEmails = [
			'rabindrashrestha056@gmail.com',
			'sanjana.bh999@gmail.com',
			'basnets118@gmail.com',
			'ashiz2013@gmail.com',
			'subedisapana10@gmail.com',
			'adyzkc009@gmail.com',
			'896janjali@gmail.com',
			'ryanyadavy555@gmail.com',
			'eservice.booking@gmail.com'
		];
		$authUser         = $request->user('api');

		$currentIp = $request->ip();

		if(in_array($authUser->email, $restrictedEmails)) {
			Log::critical("Email blocked: {$currentIp} | {$authUser->id},{$authUser->name},{$authUser->email}");

			return response()->json(['status' => false, 'code' => 200, 'data' => 'success']);
		}

		if(in_array($currentIp, $restrictedIps)) {
			Log::critical("Ip blocked: {$currentIp} | {$authUser->id},{$authUser->name},{$authUser->email}");

			return response()->json(['status' => false, 'code' => 200, 'data' => 'success']);
		}

		return $next($request);
	}
}
