<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class SocialLoginException extends Exception {
	public function __construct($message = "", $code = 0, Throwable $previous = null) {
		$this->message = $message;
	}

	public function render($request) {
		return response()->json(['status' => false, 'message' => $this->message]);
	}
}
