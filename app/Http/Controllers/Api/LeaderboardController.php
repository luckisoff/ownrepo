<?php

namespace App\Http\Controllers\Api;

use App\Leaderboard;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class LeaderboardController extends CommonController {
	private $point;


    public function get_user_points($user_id){
		/** @var User $user */
		//$user = auth()->guard('api')->user();
		$user=User::findOrFail($user_id);
	
        $leaderboard=Leaderboard::where('user_id',$user_id)->first();
        return response()->json($leaderboard);
		// $userTwoWeeksLeaderboardCount = $userTwoWeeksLeaderboard->count();
		
	}
	// save or update points obtained by user (leaderboard)
	// finished
	public function save_user_points(Request $request) {
	    
	    $validation = $this->my_validation(['point' => 'required|integer|min:0|max:10000000']);
		$validation = $this->my_validation(['point' => 'required|string']);
		if(!$validation['status']) {
			return response()->json(['status' => false, 'code' => 400, 'message' => $validation['message']], 400);
		}
		
		//$decodedPoint = base64_decode($request->input('point'), true);
		$decodedPoint=$request->input('point');

		if(!is_numeric($decodedPoint) || $decodedPoint > 135) {
			return response()->json([
				'status'  => false,
				'code'    => 400,
				'message' => ['Invalid data'],
			], 400);
		}

		$week_day = $this->get_week_day();

		$user_id=$request->user_id;
		
		try {
			DB::transaction(function() use ($week_day, $decodedPoint,$user_id) {
				$leaderboard = Leaderboard::firstOrCreate(
					['user_id' => $user_id]
				);
				
				if($decodedPoint > $leaderboard->highest_point) {
					$leaderboard->highest_point       = $decodedPoint;
					$leaderboard->highest_point_count = 1;
					$leaderboard->highest_at          = now();
				} elseif($decodedPoint == $leaderboard->highest_point) {
					$leaderboard->highest_point_count += 1;
				}
				$leaderboard->point += $decodedPoint;
				$leaderboard->count += 1;
				$leaderboard->save();
				$this->point = $leaderboard->point;
			});
		} catch(\Exception $exception) {
			return response()->json([
				'status'  => false,
				'message' => [$exception->getMessage()],
			]);
		}
		return $this->point;
		//$authUser = auth()->guard('api')->user();
		/*if($authUser->id == 12500 || $authUser->id == 38065) {
			return $this->get_logged_in_user_points();
		}*/
		
		// $validation = $this->my_validation(['point' => 'required|integer|min:0|max:10000000']);
		
		$validation = $this->my_validation(['point' => 'required|string']);
		if(!$validation['status']) {
			return response()->json(['status' => false, 'code' => 400, 'message' => $validation['message']], 400);
		}

		$decodedPoint = $request->input('point');//base64_decode($request->input('point'), true);

		if(!is_numeric($decodedPoint) || $decodedPoint > 135) {
			return response()->json([
				'status'  => false,
				'code'    => 400,
				'message' => ['Invalid data'],
			], 400);
		}

		$week_day = $this->get_week_day();

		try {
			DB::transaction(function() use ($week_day, $decodedPoint) {
				$leaderboard = Leaderboard::firstOrCreate(
					['user_id' => auth()->guard('api')->id(), 'week_day' => $week_day]
				);
				if($decodedPoint > $leaderboard->highest_point) {
					$leaderboard->highest_point       = $decodedPoint;
					$leaderboard->highest_point_count = 1;
					$leaderboard->highest_at          = now();
				} elseif($decodedPoint == $leaderboard->highest_point) {
					$leaderboard->highest_point_count += 1;
				}
				$leaderboard->point += $decodedPoint;
				$leaderboard->count += 1;
				$leaderboard->save();
				$this->point = $leaderboard->point;
			});
		} catch(\Exception $exception) {
			return response()->json([
				'status'  => false,
				'message' => [$exception->getMessage()],
			]);
		}
		// Log::useFiles(storage_path() . '/logs/' . date('Y-m-d') . '.log', 'notice');
		Log::notice("Point Log => {$decodedPoint} points by {$authUser->name}:{$authUser->email} from " . $request->ip());

		return $this->get_logged_in_user_points();
		/*return response()->json([
			'status'    => true,
			'code'      => 200,
			'userRank'  => $this->get_rank_of_user_on_week($week_day),
			'userPoint' => $this->point,
		], 200);*/
	}

	// get leaderboard points of this week and previous week winners
	public function get_leaderboard_points() {
		return response()->json([
			'status' => true,
			'code'   => 200,
			'data'   => $this->leaderboard_data(),
		]);
	}

	// get logged in user points
	public function get_logged_in_user_points() {
		/** @var User $user */
		$user = auth()->guard('api')->user();

		$week_day = $this->get_week_day();

		$userTwoWeeksLeaderboard = $user->leaderboards()
		                                ->whereBetween('week_day', [$week_day - 1, $week_day])
		                                ->orderBy('week_day', 'desc')
		                                ->limit(2)->get();

		// $userTwoWeeksLeaderboardCount = $userTwoWeeksLeaderboard->count();

		$userGroupedPoint      = $userTwoWeeksLeaderboard->groupBy('week_day');
		$userGroupedPointArray = $userGroupedPoint->toArray();
		// return $userGroupedPointArray;

		// the first data is always this weeks data

		// if week day is greater than 1
		//    if user hasn't played this week s/he has only one data
		//    if user has played this week s/he has two data
		return response()->json([
			'status' => true,
			'data'   => [
				'this_week'           => [
					'point' => array_key_exists($week_day, $userGroupedPointArray)
						? $userGroupedPointArray[ $week_day ][0]['point']
						: 0,
					'rank'  => array_key_exists($week_day, $userGroupedPointArray)
						? $this->get_rank_of_user_on_week($week_day)
						: 0,
				],
				'last_week'           => [
					'point' => array_key_exists($week_day - 1, $userGroupedPointArray)
						? $userGroupedPointArray[ $week_day - 1 ][0]['point']
						: 0,
					'rank'  => array_key_exists($week_day - 1, $userGroupedPointArray)
						? $this->get_rank_of_user_on_week($week_day - 1)
						: 0,
				],
				'week_day'            => $week_day,
				'total_points'        => $user->leaderboards->sum('point'),
				'registration_count'  => $user->registration_participation()->count(),
				'registration_tokens' => $this->get_registration_token_list(),
			],
		]);
	}


	// weekly winners and this week leaderboard
	// finished
	private function leaderboard_data() {
		$week_day = $this->get_week_day();

		/** @var User $user */
		$user = auth()->guard('api')->user();

		$leaderboard_of_this_week    = Leaderboard::with('user')
		                                          ->where('week_day', $week_day)
		                                          ->orderBy('point', 'desc')
		                                          ->paginate(50);
		$this_week_leaderboard_final = $this->this_week_leaderboard($leaderboard_of_this_week);

		// if today is sunday and is before 00:05:00, set the winner
		if(today()->dayOfWeek === 0 && today()->diffInSeconds(now(), false) <= 300) {
			$winner = $this->getWinnerOfTheWeek($week_day - 1);
			if($winner) {
				$winner->winner = 1;
				$winner->save();
			}
		}

		// don't sent weekly winners response from second page of pagination
		$page = request()->query('page') ?? 1;
		if($page == 1) {
			$weekly_winners = $this->getWeeklyWinners($week_day);
		}

		$current_user_leaderboard = optional($user->leaderboards()->where('week_day', $week_day)->first());

		return [
			'weekly_winners'          => $weekly_winners ?? [],
			'this_week'               => $this_week_leaderboard_final,
			'this_week_next_page_url' => $leaderboard_of_this_week->toArray()['next_page_url'],
			'current_user'            => [
				'point'        => $current_user_leaderboard->point ?: 0,
				'game_count'   => $current_user_leaderboard->count ?: 0,
				'rank'         => $this->get_rank_of_user_on_week($week_day),
				'total_points' => $user->leaderboards->sum('point'),
			],
		];
	}

	private function this_week_leaderboard($leader_boards) {
		$this_week_leaderboard = [];
		$i                     = 0;
		foreach($leader_boards as $leaderboard) {
			if($leaderboard->user) {
				$this_week_leaderboard[] = [
					'user_name'  => $leaderboard->user->name,
					'user_email' => $leaderboard->user->email,
					'position'   => ++ $i,
					'user_image' => $leaderboard->user->social_image,
					'country'    => $leaderboard->user->country,
					'point'      => $leaderboard->point,
					// 'point'      => $leaderboard->highest_point,
					'count'      => $leaderboard->count,
				];
			}
		}

		return $this_week_leaderboard;
	}

	private function get_rank_of_user_on_week($week_day) {
		/*$thisWeekLeaderboard = Leaderboard::where('week_day', $week_day)
		                                  ->get()
		                                  ->sortByDesc(function($leaderboardIndividual, $key) {
			                                  return (int)($leaderboardIndividual->point / $leaderboardIndividual->count);
		                                  })
		                                  ->values();

		foreach($thisWeekLeaderboard as $key => $thisWeekLeaderboardIndividual) {
			if($thisWeekLeaderboardIndividual->user_id == auth()->guard('api')->id()) {
				$userRank = $key + 1;
			}
		}

		return $userRank;*/
		/*$thisWeekLeaderboard = Leaderboard::select('week_day', 'highest_point', 'highest_point_count', 'highest_at', 'user_id')
		                                  ->where('week_day', $week_day)
		                                  ->orderBy('highest_point', 'desc')
		                                  ->orderBy('highest_point_count', 'desc')
		                                  ->orderBy('highest_at')
		                                  ->get();*/
		$thisWeekLeaderboard = Leaderboard::select('week_day', 'highest_point', 'highest_point_count', 'highest_at', 'user_id')
		                                  ->where('week_day', $week_day)
		                                  ->orderBy('point', 'desc')
		                                  ->get();

		foreach($thisWeekLeaderboard as $key => $thisWeekLeaderboardIndividual) {
			if($thisWeekLeaderboardIndividual->user_id == auth()->guard('api')->id()) {
				$userRank = $key + 1;

				return $userRank;
			}
		}

		return 0;
	}

	private function get_point_of_user_on_week($week_day) {
		return optional(auth()->guard('api')->user()->leaderboards()->where('week_day', $week_day)->first())->point;
	}





	// get leaderboard points of this week and previous week winners
	public function get_leaderboard_points2() {

		return response()->json([
			'status' => true,
			'code'   => 200,
			'data'   => $this->leaderboard_data2(),
		]);
	}

	// weekly winners and this week leaderboard
	// finished
	private function leaderboard_data2() {
		$week_day = $this->get_week_day();

		$this_week_leaderboard_final = $this->this_week_leaderboard(
		/*Leaderboard::with('user')
							 ->where('week_day', $week_day)
							 ->orderBy('highest_point', 'desc')
							 ->orderBy('highest_point_count', 'desc')
							 ->orderBy('highest_at')
							 ->limit(50)
							 ->get()*/
			Leaderboard::with('user')
			           ->where('week_day', $week_day)
			           ->orderBy('point', 'desc')
			           ->limit(50)
			           ->get()
		);

		/*$weekly_winners_group = Leaderboard::with('user')
		                                   ->where('week_day', '!=', $week_day)
		                                   ->orderBy('week_day')
		                                   ->orderBy('highest_point', 'desc')
		                                   ->orderBy('highest_point_count', 'desc')
		                                   ->orderBy('highest_at')
		                                   ->get()
		                                   ->groupBy('week_day');*/
		$weekly_winners_group = Leaderboard::with('user')
		                                   ->where('week_day', '!=', $week_day)
		                                   ->orderBy('week_day')
		                                   ->orderBy('point', 'desc')
		                                   ->get()
		                                   ->groupBy('week_day');

		$weekly_winners_final = [];
		foreach($weekly_winners_group as $key => $item) {
			$this_week_winner_first = optional($item->first());
			$weekly_winners_final[] = [
				'week'       => $key,
				'user_name'  => $this_week_winner_first->user->name,
				'user_image' => $this_week_winner_first->user->social_image,
				'country'    => $this_week_winner_first->user->country,
				'point'      => $this_week_winner_first->point,
				// 'point'      => $this_week_winner_first->highest_point,
				'count'      => $this_week_winner_first->count,
			];
		}

		return [
			'weekly_winners' => $weekly_winners_final,
			'this_week'      => $this_week_leaderboard_final,
		];
	}



	public function get_leaderboard_points3(Request $request) {
		// ->only('position', 'user_name', 'user_email', 'user_image')
		$leaderboard_data_3 = $this->leaderboard_data3($request->week_day, $request->data_limit);

		$data = [];

		foreach($leaderboard_data_3['this_week'] as $item) {
			$data[] = [
				'position' => $item['position'],
				'name'     => $item['user_name'],
				'email'    => $item['user_email'],
				'image'    => $item['user_image'],
				'point'    => $item['point'],
				'count'    => $item['count'],
			];
		}

		return response()->json([
			'status'   => true,
			'code'     => 200,
			'week_day' => $request->week_day,
			'data'     => $data,
		]);
	}


	private function leaderboard_data3($week_day = 4, $limit = 20) {
		if($week_day == 23) {
			$limit = 22;
		}
		$this_week_leaderboard_final = $this->this_week_leaderboard(
			Leaderboard::with('user')
			           ->where('week_day', $week_day)
			           ->orderBy('point', 'desc')
			           ->limit($limit)
			           ->get()
		);

		return [
			'this_week' => $this_week_leaderboard_final,
		];
	}

	private function getWinnerOfTheWeek($week_day) {
		return Leaderboard::with('user')
		                  ->where('week_day', $week_day)
		                  ->orderBy('point', 'desc')
		                  ->first();
	}

	/**
	 * @param $week_day
	 *
	 * @return array
	 */
	private function getWeeklyWinners($week_day): array {
		$weekly_winners = Leaderboard::with('user')
		                             ->where('week_day', '!=', $week_day)
		                             ->where('winner', 1)
		                             ->orderBy('week_day')
		                             ->get();

		$weekly_winners_final = [];
		foreach($weekly_winners as $key => $weekly_winner) {
			$weekly_winners_final[] = [
				'week'       => $weekly_winner->week_day,
				'user_name'  => $weekly_winner->user->name,
				'user_image' => $weekly_winner->user->social_image,
				'country'    => $weekly_winner->user->country,
				'point'      => $weekly_winner->point,
				// 'point'      => $weekly_winner->highest_point,
				'count'      => $weekly_winner->count,
			];
		}

		return $weekly_winners_final;
	}
}
