<?php

namespace App\Http\Middleware;

use Closure;

class SingleUserLoginMiddleware {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure                 $next
	 *
	 * @return mixed
	 */
	public function handle($request, Closure $next) {

		$user = auth()->guard('api')->user();

		return $user;
		
		if(is_null($user->last_login_at)) {
			return $next($request);
		}

		$accessToken = explode(' ', $request->header('Authorization'))[1];
		$payload     = json_decode(base64_decode(explode('.', $accessToken)[1]), true);
		if($this->loginTokenHasChanged($payload, $user)) {
			return response()->json([
				'status'  => false,
				'message' => 'Only one user can login at a time.',
				'code'    => 601,
			], 401);
		}

		return $next($request);
	}

	/**
	 * If a user logs in, a new login token is generated for him. Check if the generation time of the passed token
	 * matches the on in the database
	 *
	 * @param $payload
	 * @param $user
	 *
	 * @return bool
	 */
	private function loginTokenHasChanged($payload, $user): bool {
		return $payload['iat'] != $user->last_login_at;
	}
}
