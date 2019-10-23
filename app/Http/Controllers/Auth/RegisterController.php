<?php

namespace App\Http\Controllers\Auth;

use App\Mail\VerifyEmail;
use App\Role;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller {
	/*
	|--------------------------------------------------------------------------
	| Register Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users as well as their
	| validation and creation. By default this controller uses a trait to
	| provide this functionality without requiring any additional code.
	|
	*/

	use RegistersUsers;

	/**
	 * Where to redirect users after registration.
	 *
	 * @var string
	 */
	protected $redirectTo = '/login';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('guest');
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array $data
	 *
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data) {
		return Validator::make($data, [
			'name'     => 'required|string|max:255',
			'email'    => 'required|string|email|max:255|unique:users',
			'password' => 'required|string|min:6|confirmed',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array $data
	 *
	 * @return \App\User
	 */
	protected function create(array $data) {
		/*return User::create([
				'name' => $data['name'],
				'email' => $data['email'],
				'password' => bcrypt($data['password']),
		]);*/

		// --------------------------------------------------------------------
		// this part is added by ashish dhamala
		// --------------------------------------------------------------------
		$normalRole        = Role::where('name', 'normal')->first();
		$user              = new User;
		$user->name        = $data['name'];
		$user->email       = $data['email'];
		$user->password    = bcrypt($data['password']);
		$user->email_token = str_random(10);
		$user->save();
		Mail::to($user)->send(new VerifyEmail($user));
		$user->roles()->attach($normalRole);
		request()->session()->flash('success_message', 'You are registered. Please verify your email to login.');

		return $user;
		// --------------------------------------------------------------------
	}

	// Get the user who has the same token and change his/her status to verified i.e. 1
	public function verify($token) {
		// The verified method has been added to the user model and chained here
		// for better readability
		User::where('email_token', $token)->firstOrFail()->email_verified();

		return 'Your email is verified. Now you can login using our app.';
	}
}
