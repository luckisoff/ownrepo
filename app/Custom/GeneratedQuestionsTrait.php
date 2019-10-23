<?php

namespace App\Custom;

use App\Option;
use App\User;

trait GeneratedQuestionsTrait {
	/**
	 * @param $questions
	 * @param $questionIds
	 * @param $answerIds
	 *
	 * @throws \Exception
	 */
	public function validateGeneratedQuestions($questions, $questionIds, $answerIds) {
		$this->checkIfQuestionsAreGeneratedFromServer($questions);

		$this->checkForQuestionAndOptionsValidity($questions, $questionIds, $answerIds);
	}

	/**
	 * @param $questions
	 *
	 * @throws \Exception
	 */
	private function checkIfQuestionsAreGeneratedFromServer($questions) {
		if($questions->count() == 0) {
			throw new \Exception('No questions generated from the server.', 200);
		}
	}

	/**
	 * @param $questions
	 * @param $questionIds
	 * @param $answerIds
	 *
	 * @throws \Exception
	 */
	private function checkForQuestionAndOptionsValidity($questions, $questionIds, $answerIds) {
		foreach($questionIds as $key => $questionId) {
			if($questionId != $questions[ $key ]->id) {
				throw new \Exception('Failure on question matching.', 200);
			}

			/** @var Option $option */
			$option = Option::find($answerIds[ $key ] ?? 0);
			if($option && $option->is_answer() && $option->question_id == $questionId) {
			} else {
				throw new \Exception('Failure on option matching.', 200);
			}
		}
	}

	/**
	 * Generate and send success quiz participation token
	 *
	 * @param $quizType
	 *
	 * @return string
	 */
	private function saveSuccessToken($quizType): string {
		$randomAlphaNumericString = randomAlphaNumericString(10);

		/** @var User $user */
		$user = auth()->guard('api')->user();

		$user->quiz_participation()->create([
			'token' => $randomAlphaNumericString,
			'type'  => $quizType,
		]);

		return $randomAlphaNumericString;
	}
}
