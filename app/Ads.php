<?php

namespace App;

class Ads extends Model {
	protected $guarded = ['id', 'visits'];

	public function increaseVisitsUniquely() {
		$sessionKey = "ip-address-{$this->id}";
		if(!session()->has($sessionKey) && request()->ip() !== session()->get($sessionKey)) {
			$this->increment('visits');
		}

		session([$sessionKey => request()->ip()]);
	}
}
