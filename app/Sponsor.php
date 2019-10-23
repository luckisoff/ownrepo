<?php

namespace App;

class Sponsor extends Model {
	protected $guarded = ['id'];
	protected $hidden = ['created_at', 'updated_at'];

	public function getBackgroundImageAttribute($value) {
		return !is_null($value)
			? asset($this->image_path . $value)
			: asset($this->image_path . "no-image.jpg");
	}

	public function getAdImageAttribute($value) {
		return !is_null($value)
			? asset($this->image_path . $value)
			: '';
	}

	public function prizes() {
		return $this->hasMany(Prize::class);
	}

	public function questions() {
		return $this->hasMany(Question::class);
	}
}
