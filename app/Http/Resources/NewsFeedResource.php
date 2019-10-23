<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class NewsFeedResource extends Resource {
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return array
	 */
	public function toArray($request) {
		return [
			'type'      => $this->type,
			'title'     => $this->title,
			$this->mergeWhen($this->type === 'news', [
				'image'             => optional($this->images->first())->image ?: asset('public/images/no-image.jpg'),
				'short_description' => str_limit(strip_tags($this->description), 72),
				'description'       => $this->description,
			]),
			$this->mergeWhen($this->type === 'video', [
				'video' => $this->youtube_url,
			]),
			$this->mergeWhen($this->type === 'gallery', [
				'images' => array_flatten($this->images()->select('image')->get()->toArray()),
			]),
			'createdAt' => $this->created_at->toDateTimeString(),
			'updatedAt' => $this->updated_at->toDateTimeString(),
		];
	}
}
