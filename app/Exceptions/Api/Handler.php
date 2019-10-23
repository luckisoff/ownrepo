<?php

namespace App\Exceptions\Api;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler {
	private $exception;
	private $statusCode;

	/**
	 * Handler constructor.
	 *
	 * @param \Exception $exception
	 */
	public function __construct(\Exception $exception) {
		$this->exception  = $exception;
		$this->statusCode = Response::HTTP_OK;
	}

	/**
	 * @return integer
	 */
	public function getStatusCode() {
		return $this->statusCode;
	}

	/**
	 * @return string
	 */
	public function getMessage() {
		if($this->defaultMessageExists()) {
			return $this->defaultMessage();
		}

		return $this->customMessage();
	}

	/**
	 * @return bool
	 */
	private function defaultMessageExists() {
		return !empty($this->defaultMessage());
	}

	/**
	 * @return string
	 */
	private function defaultMessage() {
		if($this->exception instanceof ModelNotFoundException) {
			$this->statusCode = Response::HTTP_NOT_FOUND;

			return 'Page not found.';
		}

		if($this->exception instanceof AuthenticationException) {
			$this->statusCode = Response::HTTP_UNAUTHORIZED;

			return 'Unauthenticated.';
		}

		return $this->exception->getMessage();
	}

	/**
	 * @return string
	 */
	private function customMessage() {
		if($this->exception instanceof NotFoundHttpException) {
			$this->statusCode = Response::HTTP_NOT_FOUND;

			return 'Page not found.';
		}

		if($this->exception instanceof MethodNotAllowedHttpException) {
			$this->statusCode = Response::HTTP_METHOD_NOT_ALLOWED;

			return 'Method not allowed.';
		}

		return $this->defaultErrorMessage();
	}

	/**
	 * @return string
	 */
	private function defaultErrorMessage() {
		return "Error: " . class_basename($this->exception);
	}
}