<?php

namespace App;

class NewsFeed extends Model {
	public function images() {
		return $this->morphMany(Image::class, 'imageable');
	}

	public function scopeNews($query) {
		return $query->where('type', 'news');
	}

	public function scopeVideo($query) {
		return $query->where('type', 'video');
	}

	public function scopeGallery($query) {
		return $query->where('type', 'gallery');
	}
}
