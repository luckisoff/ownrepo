<?php

namespace App\Exceptions\Api;

use Exception;

class ValidationFailed extends Exception {
	public function render($request) {
		return response()->json([
			'status'  => false,
			'code'    => 422,
			'message' => $this->getMessageAsArray(),
		]);
	}

	/**
	 * Return message as array
	 *
	 * @return array
	 */
	private function getMessageAsArray(): array {
		return explode('|||', $this->getMessage());
	}
}
