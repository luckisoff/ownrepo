<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Mail\VerifyEmail;
use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends AsdhController {
	protected $image_prefix = 'user';

	public function __construct() {
		parent::__construct();
		$this->website['routeType'] = 'user';
	}

	public function index() {
		$this->website['users'] = User::latest()->paginate($this->default_pagination_limit);
		$this->website['roles'] = Role::where('name', '!=', 'normal')->get();

		return view('admin.user.index', $this->website);
	}

	public function create() {
		$this->website['roles'] = Role::where('name', '!=', 'normal')->get();

		return view('admin.user.create', $this->website);
	}

	public function store(Request $request) {
//    $this->validate($request, ['g-recaptcha-response'=>'recaptcha']);
		$user               = new User();
		$default_role       = Role::where('name', 'normal')->first();
		$dob                = new Carbon($request->dob);
		$user->name         = $request->name;
		$user->email        = $request->email;
		$user->password     = bcrypt($request->password);
		$user->address      = $request->address;
		$user->dob          = $dob->toDateTimeString();
		$user->about        = $request->about;
		$user->facebook_url = $request->facebook_url;
		$user->twitter_url  = $request->twitter_url;
		$user->phone        = $request->phone;
		$user->email_token  = str_random(10);
		$roles              = ($request->role !== null) ? $request->role : $default_role;

		if(!is_null($request->image)) {
			$image_name  = upload_image_modified($request->image, $this->image_prefix);
			$user->image = $image_name;
		}

		if($user->save()) {
			$user->roles()->attach($roles);

			// send verification email to newly created user
			// Mail::to($user)->send(new VerifyEmail($user));

			return $request->ajax()
				? "You have successfully signed up. Please check your email to verify it."
				: back()->with('success_message', 'User successfully created');
		} else {
			return $request->ajax()
				? "Sorry, sign up process could not be successful. Please try again later."
				: back()->with('failure_message', 'Sorry, user could not be created. Please try again later');
		}
	}

	public function edit(User $user) {
		$this->website['user']  = $user;
		$this->website['roles'] = Role::where('name', '!=', 'normal')->get();

		return view('admin.user.edit', $this->website);
	}

	public function update(UserRequest $request, $id) {
		$user               = User::find($id);
		$default_role       = Role::where('name', 'normal')->first();
		$dob                = new Carbon($request->dob);
		$user->name         = $request->name;
		$user->email        = $request->email;
		$user->address      = $request->address;
		$user->phone        = $request->phone;
		$user->dob          = $dob->toDateTimeString();
		$user->about        = $request->about;
		$user->facebook_url = $request->facebook_url;
		$user->twitter_url  = $request->twitter_url;
		$roles              = ($request->role !== null) ? $request->role : $default_role;

		// if image is present, delete previous image and assign name of newly uploaded image to model.
		if(!is_null($request->image)) {
			$user->delete_image();
			$user->image = upload_image_modified($request->image, $this->image_prefix);
		}

		if($user->save()) {
			$user->roles()->sync($roles);

			return back()->with('success_message', 'Successfully updated');
		} else {
			return back()->with('failure_message', 'Sorry, it could not be updated. Please try again later');
		}
	}

	public function destroy(User $user) {
		if(auth()->id() == $user->id) {
			return back()->with('failure_message', 'Sorry, you cannot delete yourself.');
		}

		if($user->delete()) {
			// File::delete($user->image_path());
			$user->delete_image();

			return back()->with('success_message', 'User successfully deleted.');
		}

		return back()->with('failure_message', 'User could not be deleted. Please try again later.');
	}

	public function profile() {
		$this->website['user'] = auth()->user();

		return view('admin.user.profile', $this->website);
	}

	public function change_password_form() {
		return view('admin.user.change_password', $this->website);
	}

	public function change_password(Request $request) {
		$request->validate([
			'old_password'              => 'bail|required|string|min:6',
			'new_password'              => 'bail|required|string|min:6|same:new_password_confirmation',
			'new_password_confirmation' => 'bail|required|string|min:6',
		]);

		$user = auth()->user();
		if(Hash::check($request->old_password, $user->password)) {

			$user->password = bcrypt($request->new_password);
			if($user->save()) {
				return redirect()->back()->with('success_message', 'Your password has been changed successfully');
			} else {
				return redirect()->back()->with('failure_message', 'Sorry, your password could not be changed. Please try again later.');
			}
		}

		return redirect()->back()->with('failure_message', 'Your old password did not match. Please try again.');
	}

}
