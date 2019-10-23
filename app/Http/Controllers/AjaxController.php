<?php

namespace App\Http\Controllers;

use App\Advertisement;
use App\Custom;
use App\Image;
use App\Setting;
use App\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AjaxController extends Controller {
	private function my_validation($validation, $customErrorMessages = []) {
		$validator = Validator::make(request()->all(), $validation, $customErrorMessages);
		if($validator->fails()) {
			return ['status' => false, 'messages' => $validator->errors()->all()];
		}

		return ['status' => true];
	}

	public function changeCustomShowOnHomeStatus(Request $request) {
		$custom       = Custom::find($request->id);
		$custom->home = (optional($custom)->home == 1) ? 0 : 1;
		$custom->save();

		return $custom->home
			? response()->json(['message' => 'This news is now shown on home'])
			: response()->json(['message' => 'This news is now not shown on home']);
	}

	public function makeSlug(Request $request) {
		$validation = $this->my_validation(['string' => 'string|max:255'], [
			'string.string' => 'The title field is required',
		]);
		if(!$validation['status']) {
			return response()->json(['status' => false, 'messages' => $validation['messages']]);
		}

		return response()->json(['status' => true, 'slug' => asdh_str_slug($request->input('string'))]);
	}

	public function deleteGalleryImage(Image $image) {
		if($image->delete()) {
			$image->delete_image();

			return response()->json(['message' => 'Image successfully deleted.']);
		}

		return response()->json(['message' => 'Image could not be deleted. Please try again later.']);
	}

	public function makeAdvertisementActive(Advertisement $advertisement) {
		Advertisement::where('category', $advertisement->category)
		             ->where('type', $advertisement->type)
		             ->update(['active' => 0]);

		$advertisement->update(['active' => 1]);

		return response()->json(['message' => 'Advertisement made active.']);
	}

	public function getPrizesOfSponsor(Sponsor $sponsor) {
		return response()->json(['prizes' => $sponsor->prizes()->select('description')->get()]);
	}

	public function saveNoticeStatus(Request $request) {
		$setting = Setting::first() ?? new Setting();

		$setting->notice_status  = $request->notice_status;
		$setting->notice_title   = $request->notice_title;
		$setting->notice_message = $request->notice_message;

		$setting->save();

		return response()->json(['message' => 'Success']);
	}
}
