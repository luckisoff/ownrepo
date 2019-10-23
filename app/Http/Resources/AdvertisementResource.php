<?php

namespace App\Http\Resources;

use App\Advertisement;
use Illuminate\Http\Resources\Json\Resource;

class AdvertisementResource extends Resource {
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return array
	 */
	public function toArray($request) {
		return [
			'topBanner' => Advertisement::category(0)->active()->get()->toArray()
		];
	}
}
