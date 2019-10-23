<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class LoginController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Login Controller
  |--------------------------------------------------------------------------
  |
  | This controller handles authenticating users for the application and
  | redirecting them to your home screen. The controller uses a trait
  | to conveniently provide its functionality to your applications.
  |
  */

  use AuthenticatesUsers;

  /**
   * Where to redirect users after login.
   *
   * @var string
   */
  protected $redirectTo = '/admin';

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest')->except('logout');
  }

  // Written by Ashish Dhamala
  protected function sendFailedLoginResponse(Request $request)
  {
    if ($user = User::where('email', $request->email)->first()) {
      if (!$user->verified) {
        return redirect()->back()
          ->withInput($request->only($this->username(), 'remember'))
          ->withErrors([
            'verified' => Lang::get('auth.verified'),
          ]);
      }
    }

    $errors = [$this->username() => trans('auth.failed')];

    if ($request->expectsJson()) {
      return response()->json($errors, 422);
    }

    return redirect()->back()
      ->withInput($request->only($this->username(), 'remember'))
      ->withErrors($errors);

  }

  public function logout(Request $request)
  {
    $is_admin = auth()->user()->hasRole('admin');

    if (auth()->check()) { // if a user is logged in
      $this->guard()->logout();
      $request->session()->flush();
      $request->session()->regenerate();

      if ($is_admin) {
        return redirect()->route('admin_home');
      } else {
        return redirect()->route('home');
      }
    }

    // if a user in not logged in, return false. i.e. do nothing
    return false;
  }

  // modified by ashish dhamala
  // allow login to only verified users
  public function credentials(Request $request)
  {
    return [
      'email' => $request->email,
      'password' => $request->password,
      'verified' => 1,
      'email_token' => null,
    ];
  }

}
