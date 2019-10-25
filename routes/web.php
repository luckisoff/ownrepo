<?php
Auth::routes();
Route::prefix('admin')->group(function() {

	// admin routes that are all authenticated with authorization
	Route::middleware(['auth', 'authorized_users'])->group(function() {
		Route::get('/', 'AdminController@index')->name('admin_home');

		// routes only admin can access
		Route::group(['middleware' => 'role', 'roles' => ['admin']], function() {

			Route::get('change-password', 'UserController@change_password_form')->name('user.password.change');
			Route::post('change-password', 'UserController@change_password')->name('user.password.change.store');
			Route::resource('company', 'CompanyController');
			Route::resource('user', 'UserController');
			Route::get('my-profile', 'UserController@profile')->name('user.profile');
			Route::resource('category', 'CategoryController');

			Route::resource('difficulty-level', 'DifficultyLevelController');
			Route::post('question-set-collection/add-question-sets/{question_set_collection}', 'QuestionSetCollectionController@add_question_sets_to_collection')->name('question-set-collection.add-question-sets');
			Route::resource('question-set-collection', 'QuestionSetCollectionController');
			Route::resource('question-set', 'QuestionSetController');
			Route::resource('sponsor', 'SponsorController');
			Route::get('question/excel-upload', 'QuestionController@excelUpload')->name('question.upload-excel');
			Route::post('question/excel-upload', 'QuestionController@excelUploadStore')->name('question.upload-excel.store');
			Route::resource('question', 'QuestionController');
			Route::resource('option', 'OptionController');
			Route::resource('f-question', 'FastestFingerFirstQuestionController');
			Route::resource('news-feed', 'NewsFeedController');
			Route::resource('notification', 'NotificationController');
			Route::resource('prize', 'PrizeController');
			Route::resource('ads', 'AdsController');


			Route::resource('setquestion','SetQuestionController');
			Route::resource('question-type','QuestionTypeController');

			Route::get('select-user-from-registration', 'KbcRegistrationController@selectUserRandomly')->name('registration.selection');

			Route::prefix('advertisement')->group(function() {
				Route::get('/', 'AdvertisementController@topBanner')->name('top-banner.create');
				Route::post('/', 'AdvertisementController@topBannerStore')->name('top-banner.store');
				Route::get('{top_banner}', 'AdvertisementController@topBannerEdit')->name('top-banner.edit');
				Route::put('{top_banner}', 'AdvertisementController@topBannerUpdate')->name('top-banner.update');
				Route::delete('{top_banner}', 'AdvertisementController@topBannerDestroy')->name('top-banner.destroy');
			});

			// ajax requests
			Route::get('notice-status/save', 'AjaxController@saveNoticeStatus')->name('notice-status.save');
			Route::get('change-custom-show-on-home-status', 'AjaxController@changeCustomShowOnHomeStatus')->name('ajax.custom.home');
			Route::post('make-slug', 'AjaxController@makeSlug')->name('ajax.make-slug');
			Route::post('delete-gallery-image/{image}', 'AjaxController@deleteGalleryImage')->name('ajax.gallery-image.delete');
			Route::post('make-active/{advertisement}', 'AjaxController@makeAdvertisementActive')->name('ajax.advertisement.make-active');
			Route::get('get-prizes-of-sponsor/{sponsor}', 'AjaxController@getPrizesOfSponsor')->name('ajax.sponsor.prizes');
		});
	});
});

Route::prefix('/')->group(function() {

	// it verifies the user based on his/her email
	Route::get('/register/verify/{token}', 'Auth\RegisterController@verify')->name('verify');

	Route::get('ad/{slug}', 'WebsiteController@ad')->name('ad');
	Route::post('contact-us', 'WebsiteController@contactUs')->name('contact-us');
	Route::get('privacy-policy', 'WebsiteController@privacyPolicy')->name('privacy-policy');
	Route::get('tou', 'WebsiteController@termsOfUse')->name('terms-of-use');
	Route::get('reg/tou', 'WebsiteController@registrationTermsOfUse')->name('reg.terms-of-use');
	Route::get('/', 'WebsiteController@index')->name('home');
	Route::get('test', 'WebsiteController@test')->name('test');

	Route::get('send-email-to-winners', 'WebsiteController@sendWinnerEmailForm')->name('send-winner-email.form');
	Route::get('send-email-to-winners-post', 'WebsiteController@sendWinnerEmail')->name('send-winner-email');

	Route::get('leaderboard', 'WebsiteController@leaderboard');

});

Route::get('hello-world', function() {
	return "";
});