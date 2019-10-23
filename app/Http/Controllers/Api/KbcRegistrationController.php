<?php

namespace App\Http\Controllers\Api;

use App\Advertisement;
use App\Category;
use App\Custom\GeneratedQuestionsTrait;
use App\Http\Requests\Api\RegistrationQuizSubmissionRequest;
use App\Option;
use App\Question;
use App\User;
use Illuminate\Http\Request;

class KbcRegistrationController extends CommonController {
	use GeneratedQuestionsTrait;

	/**
	 * Get 5 random questions from the category registration and store it in database for further verification
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function registration_questions() {
		// return $this->get_registration_token_list();
		$category = Category::with('questions')->where('name', 'registration')->first();

		if($this->categoryHasLessThanFiveQuestions($category)) {
			return response()->json(['status' => false, 'code' => 200, 'message' => 'No questions for registration'], 200);
		}

		$questions = $category->questions->shuffle()->take(5)->sortBy('id')->values();

		$return_data                  = $this->format_according_to_multi_language($questions);
		$advertisement                = Advertisement::active()->type('top')->category(3)->first();
		$return_data['advertisement'] = [
			'image' => $advertisement->image ?? '',
			'url'   => $advertisement->url ?? '',
		];

		$this->sync_asked_questions_for_validation($questions);

		return response()->json(['status' => true, 'code' => 200, 'data' => $return_data], 200);
	}

	/**
	 * Check answer as per question
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function check_answer(Request $request) {
		$questionId = $request->input('questionId');
		$answerId   = $request->input('answerId');

		$question = Question::findOrFail($questionId);
		$answer   = $question->options()->where('id', $answerId)->where('answer', 1)->first();

		if($answer) {
			return response()->json(['status' => true, 'code' => 200], 200);
		}

		return response()->json(['status' => false, 'code' => 200], 200);
	}

	/**
	 * Validate questions and save the token on success registration
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function submit_registration(Request $request) {
		$data      = $request->input('data');
		$questions = $data['qA'];
		$duration  = $data['duration'];

		/** @var User $user */
		$user           = auth()->guard('api')->user();
		$savedQuestions = $user->registration_questions()->orderBy('id')->get();

		if($savedQuestions->count() == 0) {
			return response()->json([
				'status'  => false,
				'code'    => 200,
				'message' => 'No questions generated from the server.',
			]);
		}

		// check if the question asked and sent from user's phone are in the same order
		// and answer also matches the actual answer
		foreach($questions as $key => $question) {
			if($question['questionId'] != $savedQuestions[ $key ]->id) {
				return response()->json(['status' => false, 'code' => 200, 'message' => 'Failure on question matching.']);
			}

			$option = Option::find($question['answerId']);
			if($option->is_answer() && $option->question_id == $question['questionId']) {
			} else {
				return response()->json(['status' => false, 'code' => 200, 'message' => 'Failure on option matching.']);
			}
		}

		$user->registration_participation()->create([
			'token'    => str_random(100),
			'selected' => 1,
		]);

		$this->deleteGeneratedQuestions($user);

		return response()->json(['status' => true, 'code' => 200, 'message' => 'Success.']);
	}

	/**
	 * Validate questions and save the token on success registration | The difference is only request parameters
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function submit_registration_2(RegistrationQuizSubmissionRequest $request) {
		$questionIds = $request->questionIds;
		$answerIds   = $request->answerIds;

		/** @var User $user */
		$user = auth()->guard('api')->user();

		$user->age    = $request->input('age');
		$user->gender = $request->input('gender');
		$user->save();

		$savedQuestions = $user->registration_questions()->orderBy('id')->get();

		$this->validateGeneratedQuestions($savedQuestions, $questionIds, $answerIds);

		$randomAlphaNumericString = randomAlphaNumericString(10);
		$user->registration_participation()->create([
			'token'    => $randomAlphaNumericString,
			'selected' => 0,
		]);

		$this->deleteGeneratedQuestions($user);

		return response()->json([
			'status'             => true,
			'code'               => 200,
			'message'            => 'Success.',
			'registration_count' => $user->registration_participation()->count(),
			'registration_token' => $randomAlphaNumericString,
		]);

	}

	/**
	 * Format the questions collection according to multiple language
	 *
	 * @param $questions
	 *
	 * @return array
	 */
	private function format_according_to_multi_language($questions): array {
		$return_data = [];
		foreach($questions as $question) {
			$return_data['english'][] = [
				'questionId' => $question->id,
				'question'   => $question->name,
				'type'       => $question->type,
				'file'       => $question->type == 'audio' ? $question->file : null,
				'options'    => $question->options()->select('id', 'name', 'answer')->get()->shuffle()->toArray(),
			];
			$return_data['nepali'][]  = [
				'id'       => $question->id,
				'question' => $question->nepali()->name,
				'type'     => $question->type,
				'file'     => $question->type == 'audio' ? $question->file : null,
				'options'  => $question->options_nepali(),
			];
		}

		return $return_data;
	}

	/**
	 * Store question generated from server for further validation
	 *
	 * @param $questions
	 *
	 * @return void
	 */
	private function sync_asked_questions_for_validation($questions): void {
		/** @var User $user */
		$user = auth()->guard('api')->user();

		$user->registration_questions()->sync($questions->pluck('id')->toArray());
	}

	/**
	 * Check if category exists and has more than 5 questions
	 *
	 * @param $category
	 *
	 * @return bool
	 */
	private function categoryHasLessThanFiveQuestions($category): bool {
		return !$category || ($category && $category->questions->count() < 5);
	}

	/**
	 * Delete generated questions
	 *
	 * @param User $user
	 *
	 * @return void
	 */
	private function deleteGeneratedQuestions($user) {
		$user->registration_questions()->sync([]);
	}
}
