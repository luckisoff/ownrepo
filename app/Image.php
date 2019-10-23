<?php

namespace App;

class Image extends Model {
	public $timestamps = false;

	public function imageable() {
		return $this->morphTo();
	}
}
