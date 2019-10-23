<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class SponsorResource extends Resource {
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return array
	 */
	public function toArray($request) {
		return [
			'id'              => $this->id,
			'name'            => $this->name,
			'image'           => $this->image,
			'backgroundImage' => $this->background_image,
			'adImage'         => $this->ad_image,
			'facebookId'      => $this->facebook_id ?? '',
		];
	}
}
