<?php

namespace App;

class Prize extends Model {
	protected $hidden = ['sponsor_id', 'created_at', 'updated_at'];

	public function sponsor() {
		return $this->belongsTo(Sponsor::class);
	}
}
