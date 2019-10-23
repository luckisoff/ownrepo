<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Exceptions\Api\Handler as ApiHandler;

class Handler extends ExceptionHandler {
	/**
	 * A list of the exception types that are not reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		//
	];

	/**
	 * A list of the inputs that are never flashed for validation exceptions.
	 *
	 * @var array
	 */
	protected $dontFlash = [
		'password',
		'password_confirmation',
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception $exception
	 *
	 * @return void
	 */
	public function report(Exception $exception) {
		parent::report($exception);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Exception               $exception
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $exception) {
		if($request->wantsJson() && $this->isInbuiltException($exception)) {
			return $this->renderJson($exception);
		}

		return parent::render($request, $exception);
	}

	/**
	 * @param Exception $exception
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	private function renderJson(Exception $exception) {
		$handler = new ApiHandler($exception);

		return response()->json([
			'status'  => false,
			'code'    => $handler->getStatusCode(),
			'message' => $handler->getMessage(),
		], $handler->getStatusCode());
	}

	/**
	 * @param Exception $exception
	 *
	 * @return bool
	 */
	private function isInbuiltException(Exception $exception) {
		// if full path of class has Api in it, it is custom exception else inbuilt
		return strpos(get_class($exception), 'Api') === false;
	}
}
