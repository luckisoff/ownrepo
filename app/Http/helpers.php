<?php

function upload_image_modified(\Illuminate\Http\UploadedFile $image, $prefix = "") {
	// modify the image name and upload it and return modified image name.
	$image_name_with_extension          = $image->getClientOriginalName();
	$modified_image_name_with_extension = "{$prefix}-asdh-" . date('YmdHis') . "-" . str_random(5) . "-" . str_replace(" ", "-", $image_name_with_extension);

	if($image->storeAs('images', $modified_image_name_with_extension)) {
		return $modified_image_name_with_extension;
	} else {
		return redirect()->back()->with('failure_message', 'Sorry, something went wrong while uploading the image. Please try again later!');
	}
}

function upload_file(\Illuminate\Http\UploadedFile $file, $prefix = "") {
	// modify the file name and upload it and return modified file name.
	$file_name_with_extension          = $file->getClientOriginalName();
	$modified_file_name_with_extension = "{$prefix}-asdh-" . date('YmdHis') . "-" . str_random(5) . "-" . str_replace(" ", "-", $file_name_with_extension);

	if($file->storeAs('files', $modified_file_name_with_extension)) {
		return $modified_file_name_with_extension;
	} else {
		return redirect()->back()->with('failure_message', 'Sorry, something went wrong while uploading the file. Please try again later!');
	}
}

function admin_url_material($url) {
	return asset("public/admin_material/" . $url);
}

function material_dashboard_url($url) {
	return asset("public/material_dashboard/" . $url);
}

function delete_if_exists($file_path) {
	\Illuminate\Support\Facades\File::delete($file_path);
}

function asdh_str_slug($str) {
	//return str_slug($str) . '-' . date('YmdHis');
	$str_final = str_replace('&', 'and', $str);

	return str_slug($str_final) . '-' . date('YmdHis');
}

function string_to_array($string) {
	// removes all white spaces and return array
	return preg_split('/\s+/', $string);
}

function domain_url() {
	return request()->root();
}

function url_after_domain() {
	return request()->path();
}

function check_if_menu_exists($menu, $menus) {
	foreach($menus as $menu_item) {
		if($menu === $menu_item->path) {
			return true;
		}
	}

	return false;
}

function frontend_url($url) {
	return asset("public/frontend/{$url}");
}

function categoryName($category) {
	switch($category) {
		case 0:
			return 'Top Banner Ad';
			break;
		case 1:
			return 'Leaderboard Ad';
			break;
		case 2:
			return 'Fastest Finger First Ad';
			break;
		case 3:
			return 'Registration Ad';
			break;
		case 4:
			return 'News Ad';
			break;
		default:
			return 'N/A';
	}
}

function getNewsFeedName() {
	return ucfirst(request()->query('type') ?: 'news');
}

function randomAlphaNumericString($length = 6, $string = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
	$pieces = [];
	$max    = mb_strlen($string, '8bit') - 1;
	for($i = 0; $i < $length; ++ $i) {
		$pieces [] = $string[ random_int(0, $max) ];
	}

	return implode('', $pieces);
}