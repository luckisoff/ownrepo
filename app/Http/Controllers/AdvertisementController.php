<?php

namespace App\Http\Controllers;

use App\Advertisement;
use Illuminate\Http\Request;

class AdvertisementController extends AsdhController {
	private $viewPath = 'admin.advertisement';
	private $prefix = 'ads';

	public function __construct() {
		parent::__construct();
		$this->website['routeType'] = 'top-banner';
	}

	public function topBanner(Request $request) {
		$request->validate(['category' => 'integer|min:0|max:4']);

		$this->website['edit']   = false;
		$this->website['models'] = Advertisement::latest()->category($request->query('category'))->get();

		return view($this->viewPath . '.top-banner', $this->website);
	}

	public function topBannerStore(Request $request) {
		$request->validate(['category' => 'integer|min:0|max:4']);

		$image_name = null;
		if(!is_null($request->file('image'))) {
			$image_name = upload_image_modified($request->file('image'), $this->prefix);
		}

		return Advertisement::create([
			'image'    => $image_name,
			'url'      => $request->input('url')??'#',
			'active'   => $request->input('active'),
			'type'     => $request->input('type'),
			'category' => $request->query('category'),
		])
			? redirect()->route($this->website['routeType'] . '.create', ['category' => $request->query('category')])
			            ->with('success_message', 'Advertisement successfully added.')
			: redirect()->route($this->website['routeType'] . '.create', ['category' => $request->query('category')])
			            ->with('failure_message', 'Advertisement could not be added. Please try again later.');
	}

	public function topBannerEdit(Advertisement $top_banner, Request $request) {
		$request->validate(['category' => 'integer|min:0|max:4']);

		$this->website['edit']   = true;
		$this->website['model']  = $top_banner;
		$this->website['models'] = Advertisement::category($request->query('category'))->get();

		return view($this->viewPath . '.top-banner', $this->website);
	}

	public function topBannerUpdate(Advertisement $top_banner, Request $request) {
		$request->validate(['category' => 'integer|min:0|max:4']);

		$this->website['edit']   = true;
		$this->website['model']  = $top_banner;
		$this->website['models'] = Advertisement::category($request->query('category'))->get();

		$image_name = $top_banner->getOriginal('image');
		if(!is_null($request->file('image'))) {
			$top_banner->delete_image();
			$image_name = upload_image_modified($request->file('image'), $this->prefix);
		}

		return $top_banner->update([
			'image'    => $image_name,
			'url'      => $request->input('url')??'',
			'active'   => $request->input('active'),
			'type'     => $request->input('type'),
			'category' => $request->query('category'),
		])
			? back()->with('success_message', 'Advertisement successfully updated.')
			: back()->with('failure_message', 'Advertisement could not be updated. Please try again later.');
	}

	public function topBannerDestroy(Advertisement $top_banner) {
		if($top_banner->delete()) {
			$top_banner->delete_image();

			return back()->with('success_message', 'Advertisement successfully deleted.');
		}

		return back()->with('failure_message', 'Advertisement could not be deleted. Please try again later.');
	}
}
