<?php

namespace App;

class Advertisement extends Model {
	public function categoryName() {
		switch($this->category) {
			case 0:
				return 'topBanner';
				break;
			case 1:
				return 'leaderboard';
				break;
			case 2:
				return 'fastestFingerFirst';
				break;
			case 3:
				return 'registration';
				break;
			case 4:
				return 'news';
				break;
			default:
				return 'no';
		}
	}

	public function scopeType($query, $value) {
		return $query->where('type', $value);
	}

	public function scopeCategory($query, $value) {
		// $value
		// 0 => Top Banner
		// 1 => Leaderboard
		// 2 => Fastest Finger First
		// 3 => Registration
		// 4 => News
		return $query->where('category', $value);
	}
}
