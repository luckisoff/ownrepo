<?php

namespace App;

class Leaderboard extends Model {
	protected $dates = ['highest_at'];
	protected $fillable=['point'];

	public function pointAverage() {
		return (int)($this->point / $this->count);
	}

	public function user() {
		return $this->belongsTo(User::class);
	}

	public function getRank() {

	}
}
