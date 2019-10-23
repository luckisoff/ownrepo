<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
  protected $redirectTo = '/';

  public function __construct()
  {
    $this->middleware('guest', ['except' => 'logout']);
  }

  protected function validator(array $data)
  {
    return Validator::make($data, [
      'name'     => 'required|max:255',
      'email'    => 'required|email|max:255|unique:users',
      'password' => 'required|confirmed|min:6',
    ]);
  }

  public function redirectToFacebook()
  {
    return Socialite::driver('facebook')->redirect();
  }

  public function getFacebookCallback()
  {
    $data = Socialite::driver('facebook')->user();
    dd($data);
    $user = User::where('email', $data->email)->first();
    if (!is_null($user)) {
      Auth::login($user);
      $user->name      = $data->user['name'];
      $user->social_id = $data->user['id'];
      $user->verified  = 1;
    } else {
      $user = User::where('social_id', $data->user['id'])->first();
      if (is_null($user)) {
        // Create a new user
        $user            = new User();
        $user->social_id = $data->user['id'];
        $user->name      = $data->user['name'];
        $user->email     = $data->email;
        $user->verified  = 1;
        if ($user->save()) {
          $user->roles()->sync([2]);
        }
      }
      Auth::login($user);
    }

    return $user->has_role(1)
      ? redirect(route('admin_home'))->with('success_message', 'Successfully logged in!')
      : redirect(route('home'))->with('success_message', 'Successfully logged in!');
  }

  public function redirectToGoogle()
  {
    return Socialite::driver('google')->redirect();
  }

  public function getGoogleCallback()
  {
    $data = Socialite::driver('google')->user();
    dd($data);
    $user = User::where('email', $data->email)->first();

    if (!is_null($user)) {
      Auth::login($user);
      $user->name      = $data->user['name']['givenName'] . ' ' . $data->user['name']['familyName'];
      $user->social_id = $data->user['id'];
      $user->verified  = 1;
    } else {
      $user = User::where('social_id', $data->user['id'])->first();
      if (is_null($user)) {
        // Create a new user
        $user            = new User();
        $user->name      = $data->user['name']['givenName'] . ' ' . $data->user['name']['familyName'];
        $user->social_id = $data->user['id'];
        $user->email     = $data->email;
        $user->verified  = 1;
        if ($user->save()) {
          $user->roles()->sync([2]);
        }
      }
      Auth::login($user);
    }

    return $user->has_role(1)
      ? redirect(route('admin_home'))->with('success_message', 'Successfully logged in!')
      : redirect(route('home'))->with('success_message', 'Successfully logged in!');
  }

  public function logout()
  {
    auth()->logout();

    return back()->with('success_message', 'You are logged out.');
  }
}
