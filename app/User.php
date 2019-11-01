<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable {
	use Notifiable, HasApiTokens;

	protected $guarded = ['id'];
	protected $dates = ['dob'];

	protected $hidden = [
		'password',
		'remember_token',
	];

	public function getNameAttribute($value) {
		return ucwords($value);
	}

	public function email_verified() {
		$this->verified    = 1;
		$this->email_token = null;
		$this->save();
	}

	public function verified() {
		return $this->verified ? "Yes" : "No";
	}

	public function leaderboards() {
		return $this->hasMany(Leaderboard::class, 'user_id');
	}

	public function roles() {
		return $this->belongsToMany(Role::class)->withTimestamps();
	}

	public function fastest_finger_first_questions() {
		return $this->belongsToMany(FastestFingerFirstQuestion::class, 'fastest_finger_first_completion_duration', 'user_id', 'question_id')
		            ->withPivot('duration')
		            ->withTimestamps();
	}

	public function generated_questions_from_sponsor() {
		return $this->belongsToMany(Question::class, 'generated_questions')->withPivot(['type'])->wherePivot('type', 'sponsor');
	}

	public function generated_questions_from_question_set() {
		return $this->belongsToMany(Question::class, 'generated_questions')->withPivot(['type'])->wherePivot('type', 'set');
	}

	public function quiz_participation() {
		return $this->hasMany(QuizParticipation::class, 'user_id');
	}

	public function registration_questions() {
		return $this->belongsToMany(Question::class, 'registration_questions');
	}

	public function registration_participation() {
		return $this->hasMany(RegistrationParticipation::class);
	}

	public function hasRole($role_name) {
		foreach($this->roles as $role) {
			if($role->name == $role_name) {
				return true;
			}
		}

		return false;
	}

	public function has_role($role_id) {
		foreach($this->roles as $role) {
			if($role->id == $role_id) {
				return true;
			}
		}

		return false;
	}

	public function hasOnlyRole($role_name) {
		return (count($this->roles) === 1 && $this->roles()->first()->name == $role_name);
	}

}
