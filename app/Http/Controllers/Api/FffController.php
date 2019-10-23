<?php

namespace App\Http\Controllers\Api;

use App\Advertisement;
use App\FastestFingerFirstQuestion;
use Illuminate\Http\Request;

class FffController extends CommonController {
	public function send_duration(Request $request, $questionId) {
		$decodedDuration = base64_decode($request->input('duration'), true);
		if(!is_numeric($decodedDuration)) {
			return response()->json([
				'status'  => false,
				'code'    => 400,
				'message' => ['Invalid data'],
			], 400);
		}

		auth()->guard('api')->user()
		      ->fastest_finger_first_questions()
		      ->syncWithoutDetaching([$questionId => ['duration' => $decodedDuration]]);

		$fffResponse = $this->questions()->getData('true');
		$leaderboard = $this->leaderboardOf(FastestFingerFirstQuestion::find($questionId));

		// dd($fffResponse);
		if($fffResponse['status']) {
			return response()->json([
				'status'  => true,
				'code'    => 200,
				'message' => 'Data saved.',
				'data'    => array_merge($fffResponse['data'], ['leaderboard' => $leaderboard]),
			], 200);
		}

		return response()->json([
			'status'  => true,
			'code'    => 200,
			'message' => 'Data saved.',
			'data'    => '',
		], 200);
	}

	// get a random question not played by the user
	public function questions() {
		// get questions ids played by user
		$fffQuestionsIdsPlayedByUser = auth()->guard('api')->user()
			->fastest_finger_first_questions->pluck('id')->toArray();


		// get questions not played by user
		$fffQuestion = FastestFingerFirstQuestion::select('id', 'question')
			// ->whereNotIn('id', $fffQuestionsIdsPlayedByUser)
			                                       ->get();


		// check if question is present
		if($fffQuestion->count()) {
			$randomQuestion = $fffQuestion->random();

			$advertisement = $this->getAdvertisements();

			$englishQuestion = [
				'questionId' => $randomQuestion->id,
				'question'   => $randomQuestion->question,
			];
			$nepaliQuestion  = [
				'questionId' => $randomQuestion->id,
				'question'   => optional($randomQuestion->nepali())->question,
			];
			foreach($randomQuestion->options->shuffle() as $option) {
				$englishQuestion['options'][] = [
					'name'  => $option->option,
					'order' => $option->order,
				];
				$nepaliQuestion['options'][]  = [
					'name'  => optional($option->nepali())->option,
					'order' => $option->order,
				];
			}

			return response()->json([
				'status' => true,
				'code'   => 200,
				'data'   => [
					'english'       => $englishQuestion,
					'nepali'        => $nepaliQuestion,
					'advertisement' => $advertisement,
				],
			], 200);
		}

		return response()->json(['status' => false, 'code' => 200, 'message' => 'No data available.'], 200);
	}

	private function getAdvertisements() {
		$topAd  = Advertisement::select('id', 'image', 'url', 'type')->category(2)->active()->type('top')->first();
		$fullAd = Advertisement::select('id', 'image', 'url', 'type')->category(2)->active()->type('full')->first();

		$advertisement = [];
		if(!is_null($topAd)) {
			$advertisement['topAd'] = [
				'image' => $topAd->image,
				'url'   => $topAd->url,
			];
		}

		if(!is_null($fullAd)) {
			$advertisement['fullAd'] = [
				'image' => $fullAd->image,
				'url'   => $fullAd->url,
			];
		}

		return $advertisement;
	}

	/**
	 * @param \App\FastestFingerFirstQuestion $question
	 *
	 * @return array
	 */
	public function leaderboardOf($question) {
		$players = $question->players()->select('users.id', 'name', 'social_image', 'country')
		                    ->orderBy('duration')->get();

		$leaderboard = [];
		foreach($players->take(3) as $key => $player) {
			$leaderboard[] = [
				'userId'    => $player->id,
				'userName'  => $player->name,
				'userImage' => $player->social_image,
				'country'   => $player->country,
				'duration'  => $player->pivot->duration,
			];
		}

		$rank = array_search(auth()->guard('api')->id(), $players->pluck('id')->toArray()) + 1;

		return [
			'data'            => $leaderboard,
			'currentUserRank' => $rank,
		];

	}
}
