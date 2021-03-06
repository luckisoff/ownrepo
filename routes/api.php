<?php

use Illuminate\Http\Request;

Route::get('/redirect', function() {
	$query = http_build_query([
		'client_id'     => 2,
		'redirect_uri'  => 'http://localhost',
		'response_type' => 'token',
		'scope'         => '*',
	]);

	return redirect(env('APP_URL') . '/oauth/authorize?' . $query);
});

Route::get('app-status', 'ApiController@appStatus');

Route::middleware('auth:api')->get('/user', function(Request $request) {
	return $request->user();
});

//Route::group(['middleware' => ['auth:api', 'restrictedIps']], function() {
Route::group(['middleware' => ['auth:api']], function() {
	//Route::get('live-question','Api\QuestionSetController@index');
	Route::get('profile', 'ApiController@profile');
//	Route::get('offline-questions-random', 'ApiController@offline_questions_random');
	Route::get('offline-questions-from-category/{category}', 'ApiController@offline_questions_from_category');
	Route::get('online-questions', 'ApiController@online_questions');
	Route::get('question-of-the-day', 'ApiController@question_of_the_day');
	Route::get('get-offline-questions-set', 'ApiController@get_offline_question_set');

	// Route::get('weekly-winners', 'ApiController@weekly_winners');
	// Route::post('user-points', 'ApiController@user_points'); // save points gained by user
	// Route::get('get-logged-in-user-points', 'ApiController@get_logged_in_user_points');
	Route::get('categories', 'ApiController@categories');
	Route::post('logout', 'ApiController@logout');

	Route::namespace('Api')->group(function() {
// 		Route::middleware(['throttle:2,1', 'singleUserLogin'])->group(function() {
// 			//Route::post('save-user-points', 'LeaderboardController@save_user_points');
// 		});

		//Route::get('get-logged-in-user-points', 'LeaderboardController@get_logged_in_user_points');
		//Route::get('get-leaderboard-points', 'LeaderboardController@get_leaderboard_points');

		Route::get('news-feeds', 'NewsFeedController@index');

		// fastest finger first
		Route::post('send-fff-duration/{questionId}', 'FffController@send_duration');
		Route::get('fff-question', 'FffController@questions');
		Route::get('fff-leaderboard', 'FffController@leaderboard');

		Route::post('save-device-token', 'NotificationController@saveDeviceToken');
		Route::get('notifications', 'NotificationController@index');

		Route::get('prize-list', 'PrizeController@index');

		Route::get('registration-questions', 'KbcRegistrationController@registration_questions');
		// Route::post('check-answer', 'KbcRegistrationController@check_answer');
		Route::post('submit-registration', 'KbcRegistrationController@submit_registration_2');

		Route::post('question-set/submit-quiz-result', 'QuestionSetController@submit_quiz_result');
		Route::get('questions-from-set', 'QuestionSetController@index');

		Route::post('sponsor/submit-quiz-result', 'SponsorController@submit_quiz_result');
		Route::get('sponsor/{sponsor}/questions', 'SponsorController@show');
		Route::get('sponsors', 'SponsorController@index');
	});
});
// Route::get('test', 'ApiController@test');
Route::group(['middleware'=>'jwt.verify'],function(){
	Route::get('live-question','Api\QuestionSetController@index');
	Route::get('live-question-time','Api\QuestionSetController@time');
	Route::get('get-ads','AdsController@getAds');
	//set the set_id into level 
	Route::post('set-played-level', 'QuestionLevelController@setLevel');
});
Route::post('login', 'ApiController@login');
Route::post('signup', 'ApiController@signup');
Route::post('social-signup', 'ApiController@social_signup');
Route::get('test', 'ApiController@test');
Route::get('advertisements', 'ApiController@advertisements');
Route::get('get-leaderboard-points2', 'Api\LeaderboardController@get_leaderboard_points2')->name('leaderboard.second');
Route::get('get-leaderboard-points3', 'Api\LeaderboardController@get_leaderboard_points3');

Route::namespace('Api')->group(function() {
	Route::get('get-logged-in-user-points/{id}', 'LeaderboardController@get_user_points');
	Route::post('save-user-points', 'LeaderboardController@save_user_points');
	
});
//gundruk api

Route::get('questions', 'Api\QuizController@getRandomQuestion');
Route::get('offline-questions-random', 'ApiController@offline_questions_random');
Route::get('get-questions/{country?}', 'QuestionLevelController@questions');
//get questions with set_id=level
Route::get('get-question-level/{user_id?}/{level?}', 'QuestionLevelController@questions');


//live quiz api
//Route::get('live-question','Api\QuestionSetController@index');
Route::get('live-quiz-api','Api\QuestionSetController@questionSetAPi');
Route::post('live-quiz-api-update','Api\QuestionSetController@questionSetAPiUpdate');


