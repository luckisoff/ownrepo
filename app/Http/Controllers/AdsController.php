<?php

namespace App\Http\Controllers;

use App\Ads;
use App\Http\Requests\AdsRequest;
use Illuminate\Http\Request;

class AdsController extends AsdhController {
	protected $prefix = 'image';
	private $viewPath = 'admin.ads';

	public function __construct() {
		parent::__construct();
		$this->website['routeType'] = 'ads';
	}

	public function index() {
		$this->website['models'] = Ads::all();

		return view($this->viewPath . '.index', $this->website);
	}

	public function create() {
		$this->website['edit'] = false;

		return view("{$this->viewPath}.create", $this->website);
	}

	public function store(AdsRequest $request) {
		$imageName = null;
		if(!is_null($request->file('image'))) {
			$imageName = upload_image_modified($request->file('image'), $this->prefix);
		}

		return Ads::create($this->requestData($request, $imageName))
			? redirect()->route($this->website['routeType'] . '.index')->with('success_message', 'Ads successfully added.')
			: redirect()->route($this->website['routeType'] . '.index')->with('failure_message', 'Ads could not be added. Please try again later.');
	}

	public function edit(Ads $ad) {
		$this->website['edit']  = true;
		$this->website['model'] = $ad;

		return view("{$this->viewPath}.create", $this->website);
	}

	public function update(AdsRequest $request, Ads $ad) {
		$imageName = $ad->getOriginal('image');
		if(!is_null($request->file('image'))) {
			$ad->delete_image();
			$imageName = upload_image_modified($request->file('image'), $this->prefix);
		}

		return $ad->update($this->requestData($request, $imageName))
			? back()->with('success_message', 'Ads successfully updated.')
			: back()->with('failure_message', 'Ads could not be updated. Please try again later.');
	}

	public function destroy(Ads $ad) {
		try {
			$ad->delete();
			$ad->delete_image();

			return back()->with('success_message', 'Ads successfully deleted.');
		} catch(\Exception $exception) {
			return back()->with('failure_message', 'Ads could not be deleted. Please try again later.');
		}
	}

	/**
	 * @param Request $request
	 * @param $imageName
	 *
	 * @return array
	 */
	private function requestData(Request $request, $imageName) {
		return [
			'title'       => $request->input('title'),
			'slug'        => $request->input('slug'),
			'image'       => $imageName,
			'contact'     => $request->input('contact'),
			'email'       => $request->input('email'),
			'video_link'  =>$request->input('video_link'),
			'description' => $request->input('description'),
		];
	}

	public function getAds()
	{
		$ads=Ads::select('title','contact','email','description','video_link')->orderBy('created_at','desc')->get();
		return response()->json([
			'status'          		=> true,
			'code'            		=> 200,
			'data'            		=> $ads,
		]);
	}
}
