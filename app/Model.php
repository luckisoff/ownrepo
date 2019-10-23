<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class Model extends Eloquent {
	protected $guarded = ['id'];
	protected $image_path = "public/images/";
	protected $modified_image_path = "public/images/modified/";
	protected $defaultCacheDuration = 60; // in mins

	public function setActiveAttribute($value) {
		return $this->attributes['active'] = ($value == 1) ? 1 : 0;
	}

	public function setHomeAttribute($value) {
		return $this->attributes['home'] = ($value == 1) ? 1 : 0;
	}

	public function getImageAttribute($value) {
		return !is_null($value)
			? asset($this->image_path . $value)
			: asset($this->image_path . "no-image.jpg");
	}

	public function cacheKey($key) {
		return sprintf(
			"%s/%s-%s:%s",
			$this->getTable(),
			$this->getKey(),
			$this->updated_at->timestamp,
			$key
		);
	}

	public function image_path($column_name = 'image') {
		return public_path('images/' . $this->getOriginal($column_name));
	}

	public function delete_image($column_name = 'image') {
		$this->delete_related_images($column_name);
		File::delete($this->image_path($column_name));
	}

	public function delete_file($column_name = 'file') {
		File::delete(public_path('files/') . $this->getOriginal($column_name));
	}

	// deletes images starting with the same name as current image name
	public function delete_related_images($column_name = 'image') {
		$image_name = $this->getOriginal($column_name);
		// if we don't have previous image then no need to delete it.
		if(!is_null($image_name) && file_exists($this->image_path . $image_name)) {
			$image_path = $this->image_path . $image_name;

			$img  = Image::make($image_path);
			$mask = $img->filename . '*.*';

			array_map('delete_if_exists', glob(public_path('images/modified/' . $mask)));
		}
	}

	public function image($x = 100, $y = 100, $column_name = 'image') {
		$image_name = $this->getOriginal($column_name);
		/*
		 * is_null($image_name)                          = if image is not uploaded
		 * !file_exists($this->image_path . $image_name) = if accidentally uploaded image is deleted but..
		 * ..the image name is still present in the database
		 * */
		if(is_null($image_name) || !file_exists($this->image_path . $image_name)) {
			$image_name = "no-image.jpg";
		}
		$image_path = $this->image_path . $image_name;
		$img        = Image::make($image_path);

		$image_destination_name = $img->filename . "-" . $x . "x" . $y . "." . $img->extension;
		$image_destination_path = $this->modified_image_path . $image_destination_name;

		if(!file_exists(public_path('images/modified/' . $image_destination_name))) {
			// resize image instance without changing aspect ratio
			/*$img->fit($x, $y, function ($constraint) {
				$constraint->upsize();
			});*/
			$img->fit($x, $y);
			// save image
			$img->save($image_destination_path);
		}

		return asset($image_destination_path);
	}

	public function description_striped($characters = 100) {
		return substr(strip_tags($this->description), 0, $characters);
	}

	public function scopeActive($query) {
		return $query->where('active', 1);
	}

	public function scopeHome($query) {
		return $query->where('home', 1);
	}
}
