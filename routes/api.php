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
		// Route::middleware(['throttle:2,1', 'singleUserLogin'])->group(function() {
		// 	Route::post('save-user-points', 'LeaderboardController@save_user_points');
		// });

		Route::get('get-logged-in-user-points', 'LeaderboardController@get_logged_in_user_points');
		Route::get('get-leaderboard-points', 'LeaderboardController@get_leaderboard_points');

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

	Route::middleware(['throttle:2,1', 'singleUserLogin'])->group(function() {
		Route::post('save-user-points', 'LeaderboardController@save_user_points');
	});
});
// Route::get('test', 'ApiController@test');

Route::post('login', 'ApiController@login');
Route::post('signup', 'ApiController@signup');
Route::post('social-signup', 'ApiController@social_signup');
Route::get('test', 'ApiController@test');
Route::get('advertisements', 'ApiController@advertisements');
Route::get('get-leaderboard-points2', 'Api\LeaderboardController@get_leaderboard_points2')->name('leaderboard.second');
Route::get('get-leaderboard-points3', 'Api\LeaderboardController@get_leaderboard_points3');
// Route::namespace('Sk')->group(function(){
// 	Route::post('save', 'LeaderboardController@save_user_points');
// });

Route::group(['namespace'=>'Api'],function(){
	Route::get('test', 'CommonController@test');
	Route::post('save', 'LeaderboardController@save_user_points');
});



//gundruk api

Route::get('questions', 'Api\QuizController@getRandomQuestion');
Route::get('offline-questions-random', 'ApiController@offline_questions_random');

