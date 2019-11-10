<?php

namespace App\Http\Controllers\Api;

use App\Custom\GeneratedQuestionsTrait;
use App\Http\Requests\Api\QuestionSetQuizSubmissionRequest;
use App\Question;
use App\QuestionSet;
use App\User;
use Illuminate\Http\Request;

class QuestionSetController extends CommonController {
	use GeneratedQuestionsTrait;

	/**
	 * Get questions in a question set(in current time) in random order
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index() {
		$questions = Question::with(['conversions', 'options', 'options.conversions', 'question_set'])
		                     ->whereHas('question_set', function($query) {
			                     $query->where('start_time', '>=', today());
				                     //->where('end_time', '<=', now());
		                     })
		                     ->inRandomOrder()
		                     ->get();

		if($questions->count() < 5) {
			return response()->json([
				'status'  => false,
				'code'    => 200,
				'message' => 'Not enough questions.',
			]);
		}

		//$this->saveGeneratedQuestions($questions);

		$questionSet = $questions->first()->question_set;

		return response()->json([
			'status'          		=> true,
			'code'            		=> 200,
			'quiz_type'				=>'live',
			'quiz_name'				=>$questionSet->title,
			'quiz_prize'			=>$questionSet->prize,
			'quiz_image' 			=> asset('public/images/' . $questionSet->sponser_image),
			'timer_actual'    		=>$questionSet->counter,
			'timer_milli'     		=>\Carbon\Carbon::parse($questionSet->counter)->diffInMilliseconds(),
			'start_time'	  		=>$questionSet->start_time->format('m-d-y H:m:s'),
			'color'           		=> $questionSet->color,
			'sponsor_image'	  		=>$questionSet->sponsor->image,
			'sponsor_back_image'	=>$questionSet->sponsor->background_image,
			'sponsor_ad_image'	  	=>$questionSet->sponsor->ad_image,
			'sponsor_prize'			=>$questionSet->sponsor->prize,
			'data'            		=> $this->format_according_to_multi_language($questions),
		]);
	}

	public function time()
	{
		$questionSet=QuestionSet::where('start_time', '>=', today())->first();
			if(!$questionSet) {
				return response()->json([
					'status'  => false,
					'code'    => 200,
					'message' => 'Not enough questions.',
				]);
			}

		return response()->json([
			'status'          		=> true,
			'code'            		=> 200,
			'quiz_type'				=>'live',
			'quiz_name'				=>$questionSet->title,
			'quiz_prize'			=>$questionSet->prize,
			'start_time'    		=>$questionSet->counter,
			'actual_time'	  		=>$questionSet->start_time->format('m-d-y H:m:s'),
			'sponsor_image'	  		=>$questionSet->sponsor?$questionSet->sponsor->image:'',
			'sponsor_back_image'	=>$questionSet->sponsor?$questionSet->sponsor->background_image:'',
			'sponsor_ad_image'	  	=>$questionSet->sponsor?$questionSet->sponsor->ad_image:'',
			'sponsor_prize'			=>$questionSet->sponsor?$questionSet->sponsor->prize:'',
		]);
	}
	/**
	 * Submit result after solving generated question set questions
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function submit_quiz_result(QuestionSetQuizSubmissionRequest $request) {
		$questionIds = $request->questionIds;
		$answerIds   = $request->answerIds;

		/** @var User $user */
		$user = auth()->guard('api')->user();

		$generatedQuestions = $user->generated_questions_from_question_set;

		$this->validateGeneratedQuestions($generatedQuestions, $questionIds, $answerIds);

		$randomAlphaNumericString = $this->saveSuccessToken('set');

		$this->deleteGeneratedQuestions($user);

		return response()->json([
			'status'             => true,
			'code'               => 200,
			'message'            => 'Success.',
			'registration_count' => $user->quiz_participation()->where('type', 'set')->count(),
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
			$user->generated_questions_from_question_set()->syncWithoutDetaching([$questionId => ['type' => 'set']]);
			sleep(0.05);
		}
	}

	/**
	 * Delete generated questions
	 *
	 * @param User $user
	 */
	private function deleteGeneratedQuestions($user): void {
		$user->generated_questions_from_question_set()->sync([]);
	}
}
