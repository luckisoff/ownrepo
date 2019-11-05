<?php

namespace App\Http\Controllers;

use App\Sponsor;
use Illuminate\Http\Request;

class SponsorController extends AsdhController {
	private $viewPath = 'admin.sponsor';
	protected $prefix = 'sponsor';

	public function __construct() {
		parent::__construct();
		$this->website['routeType'] = 'sponsor';
	}

	public function index() {
		$this->website['models'] = Sponsor::withCount('questions')->get();

		return view("{$this->viewPath}.index", $this->website);
	}

	public function create() {
		$this->website['edit'] = false;
		return view("{$this->viewPath}.create", $this->website);
	}

	public function store(Request $request) {
		$image_name = null;
		if(!is_null($request->file('image'))) {
			$image_name = upload_image_modified($request->file('image'), $this->prefix);
		}

		$background_image_name = null;
		if(!is_null($request->file('background_image'))) {
			$background_image_name = upload_image_modified($request->file('background_image'), $this->prefix);
		}

		$ad_image_name = null;
		if(!is_null($request->file('ad_image'))) {
			$ad_image_name = upload_image_modified($request->file('ad_image'), $this->prefix);
		}

		return Sponsor::create([
			'name'             => $request->input('name'),
			'image'            => $image_name,
			'background_image' => $background_image_name,
			'ad_image'         => $ad_image_name,
			'prize'			   =>$request->prize,
			'facebook_id'      => $request->facebook_id?$request->facebook_id:'#',
		])
			? redirect()->route($this->website['routeType'] . '.index')->with('success_message', 'Sponsor successfully added.')
			: redirect()->route($this->website['routeType'] . '.index')->with('failure_message', 'Sponsor could not be added. Please try again later.');
	}

	public function show(Sponsor $sponsor) {
		$this->website['sponsor']   = $sponsor;
		$this->website['models']    = $sponsor->questions;
		$this->website['routeType'] = 'question';

		return view("admin.category.show", $this->website);
	}

	public function edit(Sponsor $sponsor) {
		$this->website['edit']  = true;
		$this->website['model'] = $sponsor;

		return view("{$this->viewPath}.create", $this->website);
	}

	public function update(Request $request, Sponsor $sponsor) {
		$image_name = $sponsor->getOriginal('image');
		if(!is_null($request->file('image'))) {
			$sponsor->delete_image();
			$image_name = upload_image_modified($request->file('image'), $this->prefix);
		}

		$background_image_name = $sponsor->getOriginal('background_image');
		if(!is_null($request->file('background_image'))) {
			$sponsor->delete_image('background_image');
			$background_image_name = upload_image_modified($request->file('background_image'), $this->prefix);
		}

		$ad_image_name = $sponsor->getOriginal('ad_image');
		if(!is_null($request->file('ad_image'))) {
			$sponsor->delete_image('ad_image');
			$ad_image_name = upload_image_modified($request->file('ad_image'), $this->prefix);
		}

		return $sponsor->update([
			'name'             => $request->input('name'),
			'image'            => $image_name,
			'background_image' => $background_image_name,
			'ad_image'         => $ad_image_name,
			'facebook_id'      => $request->facebook_id,
		])
			? back()->with('success_message', 'Sponsor successfully updated.')
			: back()->with('failure_message', 'Sponsor could not be updated. Please try again later.');
	}

	public function destroy(Sponsor $sponsor) {
		try {
			$sponsor->delete();
			$sponsor->delete_image();
			$sponsor->delete_image('background_image');
			$sponsor->delete_image('ad_image');

			return back()->with('success_message', 'Sponsor successfully deleted.');
		} catch(\Exception $exception) {
			return back()->with('failure_message', 'Sponsor could not be deleted. Please try again later.');
		}
	}

}
