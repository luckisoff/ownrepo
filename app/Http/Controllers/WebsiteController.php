<?php

namespace App\Http\Controllers;

use App\Ads;
use App\Mail\ContactUsMail;
use App\Mail\TestMail;
use App\Mail\WinnerMail;
use App\Rules\Recaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class WebsiteController extends AsdhController {
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		return view('index', $this->website);
	}

	public function termsOfUse() {
		return view('terms-of-use', $this->website);
	}

	public function registrationTermsOfUse() {
		return view('reg-terms-of-use', $this->website);
	}

	public function privacyPolicy() {
		return view('privacy-policy', $this->website);
	}

	public function contactUs(Request $request) {
		$validData = $request->validate([
			'name'                 => 'required|string|max:255',
			'email'                => 'required|email',
			'body'                 => 'required',
			'g-recaptcha-response' => ['required', new Recaptcha],
		], ['g-recaptcha-response.required' => 'Click on I am not a robot and try again.']);

		Mail::to('info@srbnmedia.com')->send(new ContactUsMail($validData));
		Mail::to('aashish201030@gmail.com')->send(new ContactUsMail($validData));
		Mail::to('sunbi.design@gmail.com')->send(new ContactUsMail($validData));

		return back()->with('success_message', 'Your message is delivered successfully. We will contact you soon.');
	}

	public function test() {
		// dispatch(new SendEmail());
		// Mail::to('ashish.dhamala2015@gmail.com')->send(new TestMail());
	}

	public function leaderboard() {
		return view('leaderboard', $this->website);
	}

	public function sendWinnerEmailForm() {
		return view('admin.winner.email', $this->website);
	}

	public function sendWinnerEmail(Request $request) {
		$weekDay = $request->input('week_day') ?: 7;
		$limit   = $request->input('limit') ?: 20;

		$url     = "http://kbcnepal.com/api/get-leaderboard-points3?week_day={$weekDay}&data_limit={$limit}";
		$winners = $this->get_array_from_get_request($url);

		foreach($winners['data'] as $winner) {
			Mail::to($winner['email'])->send(new WinnerMail($winner, $winners['week_day']));
		}

		Mail::to('info@srbnmedia.com')->send(new WinnerMail($winners['data'][0], $winners['week_day']));
		Mail::to('aashish201030@gmail.com')->send(new WinnerMail($winners['data'][0], $winners['week_day']));
		Mail::to('sunbi.design@gmail.com')->send(new WinnerMail($winners['data'][0], $winners['week_day']));

		return "All the winners are successfully notified.";
	}

	public function ad($slug) {
		try {
			/** @var Ads $ad */
			$this->website['ad'] = $ad = Ads::where('slug', $slug)->firstOrFail();

			$ad->increaseVisitsUniquely();

			return view('ads', $this->website);
		} catch(\Exception $exception) {
			return abort(404);
		}
	}

}
