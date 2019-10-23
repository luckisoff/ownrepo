<?php

namespace App;

class OptionConversion extends Model {
	public function option() {
		return $this->belongsTo(Option::class);
	}
}
