<?php

namespace App\Exceptions;

use Exception;

class TestingException extends Exception {
	public function render($request) {
		return response()->json(['status' => true, 'data' => []]);
	}
}
