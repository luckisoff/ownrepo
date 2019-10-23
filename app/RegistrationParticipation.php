<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistrationParticipation extends Model {
	protected $table = 'registration_participation';
	protected $guarded = ['id'];
	protected $dates = ['selected_at'];

	public function scopeNotSelected($query) {
		return $query->where('selected', 0);
	}
}
