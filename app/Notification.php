<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model {
	protected $guarded = ['id'];

	public function getCreatedAtAttribute($value) {
		return Carbon::parse($value)->diffForHumans();
	}
}
