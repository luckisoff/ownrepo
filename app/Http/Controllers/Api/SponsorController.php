<?php

namespace App\Http\Controllers\Api;

use App\Custom\GeneratedQuestionsTrait;
use App\Http\Requests\Api\SponsorQuizSubmissionRequest;
use App\Http\Resources\SponsorResource;
use App\Sponsor;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class SponsorController extends Controller {
	use GeneratedQuestionsTrait;

	/**
	 * Get all the sponsors list
	 *
	 * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
	 */
	public function index() {
		$sponsors = Sponsor::select('id', 'name', 'image', 'background_image', 'ad_image', 'facebook_id')->get();

		return SponsorResource::collection($sponsors)->additional([
			'status' => true,
			'code'   => 200,
		]);
	}

	/**
	 * Get all the questions of the sponsor
	 *
	 * @param Sponsor $sponsor
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show(Sponsor $sponsor) {
		$questions = $sponsor->questions()->with(['conversions', 'options', 'options.conversions'])
		                     ->inRandomOrder()
		                     ->get();

		if($questions->count() < 5) {
			return response()->json([
				'status'  => false,
				'code'    => 200,
				'message' => 'Not enough questions.',
			]);
		}

		$this->saveGeneratedQuestions($questions);

		return response()->json([
			'status'          => true,
			'code'            => 200,
			'backgroundImage' => $sponsor->background_image,
			'data'            => $this->format_according_to_multi_language($questions),
		]);
	}

	/**
	 * Submit result after solving generated quiz questions
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function submit_quiz_result(SponsorQuizSubmissionRequest $request) {
		$questionIds = $request->questionIds;
		$answerIds   = $request->answerIds;

		/** @var User $user */
		$user = auth()->guard('api')->user();

		$generatedQuestions = $user->generated_questions_from_sponsor;

		$this->validateGeneratedQuestions($generatedQuestions, $questionIds, $answerIds);

		$randomAlphaNumericString = $this->saveSuccessToken('sponsor');

		$this->deleteGeneratedQuestions($user);

		return response()->json([
			'status'             => true,
			'code'               => 200,
			'message'            => 'Success.',
			'registration_count' => $user->quiz_participation()->where('type', 'sponsor')->count(),
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
				'options'    => $question->options
					->map(function($option) {
						return ['id' => $option->id, 'name' => $option->name, 'answer' => $option->answer];
					})
					->shuffle()
					->toArray(),
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
	 * Save the generated questions for validation while saving
	 *
	 * @param \Illuminate\Support\Collection $questions
	 */
	private function saveGeneratedQuestions($questions): void {
		/** @var User $user */
		$user = auth()->guard('api')->user();

		$this->deleteGeneratedQuestions($user);

		$questionIds = $questions->pluck('id')->toArray();
		foreach($questionIds as $questionId) {
			$user->generated_questions_from_sponsor()->syncWithoutDetaching([$questionId => ['type' => 'sponsor']]);
			sleep(0.05);
		}
	}

	/**
	 * Delete generated questions
	 *
	 * @param User $user
	 */
	private function deleteGeneratedQuestions($user): void {
		$user->generated_questions_from_sponsor()->sync([]);
	}
}
