<?php

namespace App\Http\Controllers;

use App\Advertisement;
use App\Category;
use App\Device;
use App\DifficultyLevel;
use App\Exceptions\SocialLoginException;
use App\FastestFingerFirstQuestion;
use App\Http\Controllers\Api\CommonController;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserResourceCollection;
use App\Leaderboard;
use App\Mail\VerifyEmail;
use App\Option;
use App\Question;
use App\QuestionSet;
use App\QuestionSetCollection;
use App\Role;
use App\Setting;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends CommonController {
	public function __construct() {
		parent::__construct();
	}

	private function get_array_from_post_request($url, $parameters = []) {
		try {
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
			$result = curl_exec($ch);
			curl_close($ch);
			$response = json_decode($result, true);

			return $response;
		} catch(\Exception $e) {
			return response()->json(['status' => false, 'code' => 400, 'message' => 'Login Session Expired.']);
		}
	}

	private function get_array_from_get_request($url) {
		try {
			$ch = curl_init();
			// Disable SSL verification
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			// Will return the response, if false it print the response
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			// Set the url
			curl_setopt($ch, CURLOPT_URL, $url);
			// Execute
			$result = curl_exec($ch);
			// Closing
			curl_close($ch);
			$response = json_decode($result, true);

			return $response;
		} catch(\Exception $e) {
			return response()->json(['status' => false, 'code' => 400, 'message' => 'Login Session Expired.']);
		}
	}

	private function google_signup() {
		$id_token                    = request()->input('login_token');
		$access_token                = explode('.', $id_token)[1];
		$base64_decoded_access_token = base64_decode($access_token);
		$json_data                   = json_decode($base64_decoded_access_token, true);


		/*$url = 'https://www.googleapis.com/oauth2/v3/tokeninfo?id_token=' . request()->input('login_token');
		try {
			$json_data = $this->get_array_from_get_request($url);
		} catch(\Exception $e) {
			return response()->json(['status' => false, 'code' => 400, 'message' => 'Login Session Expired.'], 400);
		}
		if(!$json_data) {
			throw new SocialLoginException('Slow internet.');
		}
		if(array_key_exists('error_description', $json_data)) {
			throw new SocialLoginException($json_data['error_description']);
		}*/

		$google_client_id_for_android = '541443288170-tql2kdsbu1flumad0uk2s59tl876dslg.apps.googleusercontent.com';
		$google_client_id_for_ios     = '541443288170-g0liqbkavp7ot466mra0o2muhu36aaqf.apps.googleusercontent.com';

		$is_verified['status'] = ($json_data['aud'] == $google_client_id_for_ios || $json_data['aud'] == $google_client_id_for_android) && ($json_data['email'] == request()->input('email'));
		$is_verified['from']   = 'google';

		return $is_verified;
	}

	private function facebook_signup() {
		$login_token = request()->input('login_token');
		// accessing user data
		$url_to_access_user_detail = 'https://graph.facebook.com/me?fields=email&access_token=' . $login_token;

		try {
			$json_data_user = $this->get_array_from_get_request($url_to_access_user_detail);
		} catch(\Exception $e) {
			return response()->json(['status' => false, 'code' => 400, 'message' => 'Login Session Expired.'], 400);
		}

		if(!$json_data_user) {
			throw new SocialLoginException('Slow internet.');
		}
		if(array_key_exists('error', $json_data_user)) {
			throw new SocialLoginException($json_data_user['error']['message']);
		}

		// accessing app data
		$url_to_access_app_id = 'https://graph.facebook.com/app?access_token=' . $login_token;
		try {
			$json_data_app = $this->get_array_from_get_request($url_to_access_app_id);
		} catch(\Exception $e) {
			return response()->json(['status' => false, 'code' => 400, 'message' => 'Login Session Expired.'], 400);
		}
		$app_id_for_android = '313635532459890';
		$app_id_for_ios     = '313635532459890';
		if(!$json_data_app) {
			throw new SocialLoginException('Slow internet.');
		}
		if(array_key_exists('error', $json_data_app)) {
			throw new SocialLoginException($json_data_app['error']['message']);
		}

		$is_verified['status'] = ($json_data_app['id'] == $app_id_for_android || $json_data_app['id'] == $app_id_for_ios) && $json_data_user['email'] == request()->input('email');
		$is_verified['from']   = 'facebook';

		return $is_verified;
	}

	protected function my_validation($validation, $messages = []) {
		$validator = Validator::make(request()->all(), $validation, $messages);
		if($validator->fails()) {
			return ['status' => false, 'message' => $validator->errors()->all()];
		}

		return ['status' => true];
	}

	public function appStatus() {
		$setting = Setting::first() ?? new Setting;

		return response()->json([
			'status'     => true,
			'app_status' => !!$setting->notice_status,
			'title'      => $setting->notice_title,
			'message'    => $setting->notice_message,
		]);
	}

	// access token is to access the authenticated stuffs
	// refresh token is to refresh the timed-out login sessions
	private function request_access_and_refresh_tokens() {
		$data = $this->get_array_from_post_request(url('oauth/token'), [
			'username'      => request()->email,
			'password'      => request()->password,
			'grant_type'    => 'password',
			'client_id'     => 8,
			'client_secret' => config('services.passport.client_2_secret'),
			'scope'         => '*',
		]);

		return $data;
	}

	public function login(Request $request) {
		/*$user = User::find(1);
		$token = $user->createToken('Access Token', ['*']);
		dd($token);*/

		// validate the login parameters
		$validation = $this->my_validation(['email' => 'required|email', 'password' => 'required|string|min:6']);
		if(!$validation['status']) {
			return response()->json(['status' => false, 'code' => 400, 'message' => $validation['message']], 400);
		}

		// if login is not successful
		if(!auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
			return response()->json(['status' => false, 'code' => 400, 'message' => 'Login failed.'], 400);
		}

		/** @var User $user */
		$user = User::where('email', $request->email)->first();

		if(is_null($user->access_token)) {
			$user->access_token = $user->createToken('Access Token', ['*'])->accessToken;
			$user->save();
		}

		return response()->json([
			'status'              => true,
			'code'                => 200,
			'data'                => $user,
			'registration_count'  => $user->registration_participation()->count(),
			'registration_tokens' => $this->get_registration_token_list($user),
		], 200);
	}

	public function signup(Request $request) {
		$validation = $this->my_validation([
			'name'     => 'required|string',
			'email'    => 'required|email|unique:users',
			'password' => 'required|min:6|confirmed',
		]);
		if(!$validation['status']) {
			return response()->json(['status' => false, 'message' => $validation['message']]);
		}

		// create user
		/** @var User $user */
		$user = User::create([
			'name'     => $request->name,
			'email'    => $request->email,
			'password' => bcrypt($request->password),
		]);

		// request for access and refresh token for api authorization
		$data = $this->request_access_and_refresh_tokens();
		return $data;
		// if there is an error, the $data variable will have error message associated with 'error' key.
		if(array_key_exists('error', $data=array())) {
			$user->delete();

			return response()->json(['status' => false, 'code' => 400, 'message' => $data], 400);
		} else {
			$normal_role         = Role::where('name', 'normal')->first();
			$user->access_token  = $data['access_token'];
			$user->refresh_token = $data['refresh_token'];
			$user->email_token   = str_random(11);
			$user->verified      = 0;
			$user->save();
			$user->roles()->attach($normal_role->id);
			// send verification email to newly created user
			//Mail::to($user)->send(new VerifyEmail($user));

			return response()->json([
				'status'              => true,
				'code'                => 200,
				'data'                => $user,
				'registration_count'  => $user->registration_participation()->count(),
				'registration_tokens' => $this->get_registration_token_list($user),
			], 200);
		}
	}

	public function social_signup(Request $request) {
		$userName = $request->input('name');
		if($userName == 'Amit Chaudhary' || $userName == 'Riya Jaiswal') {
			return response()->json(["status" => false, "message" => 'Signup/Login failed. Please try again later.']);
		}
		// validate the signup parameters
		$validation = $this->my_validation([
			'name'        => 'required|string|max:191',
			'email'       => 'required|email|max:191',
			'social_id'   => 'required|string',
			'from'        => 'required|string|min:6|max:8',
			'login_token' => 'required|string',
		]);
		if(!$validation['status']) {
			return response()->json(['status' => false, 'message' => $validation['message']]);
		}

		$login_portal = $request->input('from');
		/*if($login_portal == 'google') {
			$is_verified = $this->google_signup();
			// $is_verified['status'] = true;

		} else if($login_portal == 'facebook') {
			$is_verified = $this->facebook_signup();
			// $is_verified['status'] = true;

		} else {
			return response()->json([
				'status'  => false,
				'message' => 'Login from other than Google or Facebook is not allowed.',
			]);
		}*/

		// if($is_verified['status']) {
		if(true) {
			$old_user = User::where('email', $request->input('email'))->first();
			// if user is present
			if(!is_null($old_user)) {
				$user        = $old_user;
				$is_new_user = false;
			} else {
				$user        = new User();
				$is_new_user = true;
			}

			$user->name         = $request->input('name');
			$user->email        = $request->input('email');
			$user->social_id    = $request->input('social_id');
			$user->social_from  = $login_portal;
			$user->password     = bcrypt(str_random(10));
			$user->verified     = 1;
			$user->social_image = $request->input('image');
			$user->country      = $request->input('country');

			/*$imageUrl = $request->input('image');
			if(!is_null($imageUrl) && $imageUrl !== '') {
				$user->delete_image();
				$ext         = pathinfo($imageUrl, PATHINFO_EXTENSION);
				$name        = str_random(10);
				$nameWithExt = "user-{$name}.{$ext}";

				// upload image to server
				Image::make($imageUrl)->save(public_path("images/{$nameWithExt}"));

				$user->image = $nameWithExt;
			}*/

			if($user->save()):
				$accessToken         = $user->createToken('Access Token', ['*'])->accessToken;
				$user->access_token  = $accessToken;
				$payload             = json_decode(base64_decode(explode('.', $accessToken)[1]), true);
				$user->last_login_at = $payload['iat'];
				$user->save();

				if($is_new_user) {
					// send verification email to newly created user
					$normal_role = Role::where('name', 'normal')->first();
					$user->roles()->syncWithoutDetaching([$normal_role->id]);
					// Mail::to($user)->send(new VerifyEmail($user));
				}

				$leaderboardPoints = $user->leaderboards()->orderBy('week_day', 'desc')->get()->toArray();
				$week_day          = $this->get_week_day();

				$userTwoWeeksLeaderboard = $user->leaderboards()
				                                ->whereBetween('week_day', [$week_day - 1, $week_day])
				                                ->orderBy('week_day', 'desc')
				                                ->limit(2)->get();
				$userGroupedPoint        = $userTwoWeeksLeaderboard->groupBy('week_day');
				$userGroupedPointArray   = $userGroupedPoint->toArray();

				return response()->json([
					"status"              => true,
					'point'               => [
						'this_week' => array_key_exists($week_day, $userGroupedPointArray)
							? $userGroupedPointArray[ $week_day ][0]['point']
							: 0,
						'last_week' => array_key_exists($week_day - 1, $userGroupedPointArray)
							? $userGroupedPointArray[ $week_day - 1 ][0]['point']
							: 0,
						'total'     => collect($leaderboardPoints)->sum('point'),
					],
					'rank'                => [
						'this_week' => array_key_exists($week_day, $userGroupedPointArray)
							? $this->get_rank_of_user_on_week($week_day)
							: 0,
						'last_week' => array_key_exists($week_day - 1, $userGroupedPointArray)
							? $this->get_rank_of_user_on_week($week_day - 1)
							: 0,
					],
					"data"                => $user,
					'registration_count'  => $user->registration_participation()->count(),
					'registration_tokens' => $this->get_registration_token_list($user),
				]);
			else:
				return response()->json(["status" => false, "message" => 'Signup/Login failed. Please try again later.']);
			endif;

		} else {
			return response()->json(["status" => false, "message" => 'Client id or App id did not match.']);
		}
	}

	// get random questions for offline
	public function offline_questions_random() {
		$difficulty_levels = DifficultyLevel::get();

		$offline_questions = [];
		foreach($difficulty_levels as $difficulty_level) {
			// change ->last() to ->random()
			// $offline_questions[] = $difficulty_level->questions->last();
			$offline_questions[] = $difficulty_level->questions()->with('difficulty_level')->get()->random();
		}

		$return_data = $this->format_according_to_multi_language($offline_questions);

		return response()->json(['status' => true, 'code' => 200, 'data' => $return_data], 200);
	}

	// get random questions for offline from category
	public function offline_questions_from_category(Category $category) {
		if(!$category->hasAllDifficultyLevelQuestions()) {
			return response()->json(['status' => false, 'message' => 'No enough questions in this category.']);
		}

		$difficulty_levels = DifficultyLevel::get();
		$offline_questions = [];
		foreach($difficulty_levels as $difficulty_level) {
			// change ->first() to ->random()
			// $offline_questions[] = $difficulty_level->questions->first();
			$questions_in_this_category = $difficulty_level->questions()->with('difficulty_level')->where('category_id', $category->id)->get();
			if($questions_in_this_category->count()) {
				$offline_questions[] = $difficulty_level->questions()->with('difficulty_level')->where('category_id', $category->id)->get()->random();
			} else {
				return response()->json(['status' => false, 'message' => 'No questions in this category.']);
			}
		}

		$category->increment('view_counts', 1);

		$formatted_questions = $this->format_according_to_multi_language($offline_questions);
		// return $formatted_questions;
		$advertisement = optional(Advertisement::latest()->category(0)->active()->type('top')->first());
		$formatted_ads = [
			'image' => $advertisement->image ?: "",
			'url'   => $advertisement->url ?: "",
		];

		$return_data = array_add($formatted_questions, 'advertisement', $formatted_ads);

		return response()->json(['status' => true, 'code' => 200, 'data' => $return_data], 200);
	}

	// get questions according to question set
	public function online_questions() {
		// get today's question set collection
		//$question_set_collection = QuestionSetCollection::where('show_on', Carbon::today())->first();
		$questions = Question::take(15)->get();

		return $questions;
		if(is_null($question_set_collection)) {
			return response()->json([
				'status'  => false,
				'code'    => 400,
				'message' => 'No question set collection is assigned for today',
			], 400);
		}

		// get a random set from the collection
		$random_question_set = $question_set_collection->question_sets->random();
		// get 5 random questions from the set
		$random_questions = $random_question_set->questions->shuffle()->take(5);
		// format according to English and Nepali language
		$return_data = $this->format_according_to_multi_language($random_questions);

		return response()->json(['status' => true, 'code' => 200, 'data' => $return_data], 200);
	}

	// all categories
	public function categories() {
		$categories = Category::select('id', 'name', 'image', 'icon', 'color', 'view_counts')
		                      ->where('name', '!=', 'host')
		                      ->where('id', '!=', 15)
		                      ->where('name', '!=', 'registration')
		                      ->orderBy('name')->get()
		                      ->filter(function($category) {
			                      return $category->hasAllDifficultyLevelQuestions();
		                      })->values();

		return response()->json(['status' => true, 'code' => 200, 'data' => $categories], 200);
	}

	public function advertisements() {
		$outputData = [];
		foreach(Advertisement::latest()->active()->get()->groupBy('category') as $key => $ads) {
			foreach($ads as $ad) {
				$outputData[ $ad->categoryName() ][] = [
					'type'  => $ad->type,
					'image' => $ad->image,
					'url'   => $ad->url,
				];
			}
		}

		return response()->json([
			'status' => true,
			'code'   => Response::HTTP_OK,
			'data'   => $outputData,
		], Response::HTTP_OK);
	}

	public function logout(Request $request) {
		$validation = $this->my_validation(['token' => 'required|string']);
		if(!$validation['status']) {
			return response()->json(['status' => false, 'code' => 400, 'message' => $validation['message']], 400);
		}

		Device::where('token', $request->input('token'))->delete();

		return response()->json([
			'status'  => true,
			'code'    => Response::HTTP_OK,
			'message' => 'Logout Successful',
		], Response::HTTP_OK);
	}

	public function question_of_the_day() {
		$hour24 = Carbon::now()->hour;
		if($hour24 >= 0 && $hour24 <= 1) {
			Question::where('question_of_the_day', 1)->update(['question_of_the_day' => 0]);
			Question::inRandomOrder()->first()->update(['question_of_the_day' => 1]);
		}

		/** @var Question $question */
		// $question       = Question::inRandomOrder()->first();
		$question       = Question::where('question_of_the_day', 1)->first();
		$nepaliQuestion = $question->nepali();
		$answer         = $question->options()->where('answer', 1)->first();

		$return_data = [
			'questionId' => $question->id,
			'english'    => [
				'question' => $question->name,
				'answer'   => $answer->name,
			],
			'nepali'     => [
				'question' => $nepaliQuestion->name,
				'answer'   => $answer->nepali()->name,
			],
		];

		return response()->json(['status' => true, 'code' => 200, 'data' => $return_data], 200);
	}

	public function format_according_to_multi_language($questions) {
		$return_data = [];
		foreach($questions as $question) {
			$return_data['english'][] = [
				'questionId' => $question->id,
				'question'   => $question->name,
				'type'       => $question->type,
				'file'       => $question->type == 'audio' ? $question->file : null,
				'price'      => $question->difficulty_level->price,
				'duration'   => $question->difficulty_level->duration,
				'options'    => $question->options()->select('name', 'answer')->get()->shuffle()->toArray(),
			];
			$return_data['nepali'][]  = [
				'id'       => $question->id,
				'question' => $question->nepali()->name,
				'type'     => $question->type,
				'file'     => $question->type == 'audio' ? $question->file : null,
				'price'    => $question->difficulty_level->price,
				'duration' => $question->difficulty_level->duration,
				'options'  => $question->options_nepali(),
			];
		}

		return $return_data;
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
		$thisWeekLeaderboard = Leaderboard::select('week_day', 'highest_point', 'highest_point_count', 'highest_at', 'user_id')
		                                  ->where('week_day', $week_day)
		                                  ->orderBy('highest_point', 'desc')
		                                  ->orderBy('highest_point_count', 'desc')
		                                  ->orderBy('highest_at')
		                                  ->get();

		foreach($thisWeekLeaderboard as $key => $thisWeekLeaderboardIndividual) {
			if($thisWeekLeaderboardIndividual->user_id == auth()->guard('api')->id()) {
				$userRank = $key + 1;

				return $userRank;
			}
		}

		return 0;
	}

	private function create_questions_according_to_category() {
		for($k = 29; $k <= 32; $k ++) {
			for($i = 1; $i <= 15; $i ++) {
				$question = new Question();
				// if create question is clicked from question set index page
				$question->difficulty_level_id = $i;
				$question->category_id         = $k - 28;
				$question->online              = false;
				$question->name                = "Question Number $k-$i";
				$question->save();
				$question->conversions()->create([
					'language_id' => '1',
					'name'        => "Question Number $k-$i Nepali",
				]);

				$random_int = random_int(1, 4);
				for($j = 1; $j <= 4; $j ++) {
					$new_option = Option::create([
						'question_id' => $question->id,
						'name'        => "Question $k-$i Answer $j",
						'answer'      => $random_int == $j ? 1 : 0,
					]);

					$new_option->conversions()->create([
						'language_id' => '1',
						'name'        => "Question $k-$i Answer $j Nepali",
					]);
				}
			}
		}
	}

	private function create_questions_according_to_question_set() {
		for($k = 1; $k <= 20; $k ++) {
			$question_set = QuestionSet::create([
				'title' => "Question Set $k",
			]);

			for($i = 1; $i <= 20; $i ++) {
				$question = new Question();
				// if create question is clicked from question set index page
				$question->question_set_id = $question_set->id;
				$question->online          = true;
				$question->name            = "Question set $k Question Number $i";
				$question->save();
				$question->conversions()->create([
					'language_id' => '1',
					'name'        => "Question set $k Question Number $i Nepali",
				]);

				$random_int = random_int(1, 4);
				for($j = 1; $j <= 4; $j ++) {
					$new_option = Option::create([
						'question_id' => $question->id,
						'name'        => "Question set $k Question Number $i Answer $j",
						'answer'      => $random_int == $j ? 1 : 0,
					]);

					$new_option->conversions()->create([
						'language_id' => '1',
						'name'        => "Question set $k Question Number $i Answer $j Nepali",
					]);
				}
			}

		}
	}

	private function ipAddress(Request $request) {
		return $request->header('AP-Remote-Addr');
	}

	private function countryShortCode(Request $request) {
		return $request->header('AP-IPCountry');
	}



	protected function get_week_day() {
		// the day when quiz starts
		$quiz_start_date = Carbon::parse('2018-02-14');

		// shift the quiz start day to sunday of that week
		$modified_quiz_start_day = $quiz_start_date->subDays($quiz_start_date->dayOfWeek);

		// today
		$today = Carbon::today();


		// today - quiz start day
		$total_days_of_quiz = $today->diffInDays($modified_quiz_start_day, true);
		// total_days_of_quiz divided by seven gives quotient less than seven
		// the quotient may be float, so i floored it and made int
		// for first week it is 0
		// for second week it is 1
		// so i added 1 to start week from 1
		return (int)floor($total_days_of_quiz / 7) + 1;
	}

	public function get_offline_question_set() {
		$difficulty_levels = DifficultyLevel::get();
		$offline_questions = [];

		/** @var DifficultyLevel $difficulty_level */
		foreach($difficulty_levels as $difficulty_level) {
			// change ->first() to ->random()
			// $offline_questions[] = $difficulty_level->questions->first();
			// $offline_questions[] = $difficulty_level->questions()->with('difficulty_level')->get()->random();
			$offline_questions[] = $difficulty_level->questions()->with('difficulty_level')->inRandomOrder()->first();
		}

		$formatted_questions = $this->format_according_to_multi_language($offline_questions);
		$advertisement       = optional(Advertisement::latest()->category(0)->active()->type('top')->first());
		$formatted_ads       = [
			'image' => $advertisement->image ?: "",
			'url'   => $advertisement->url ?: "",
		];
		$return_data         = array_add($formatted_questions, 'advertisement', $formatted_ads);

		return response()->json(['status' => true, 'code' => 200, 'data' => $return_data], 200);
	}

}
