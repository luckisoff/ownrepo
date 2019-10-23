<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsFeedRequest;
use App\NewsFeed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsFeedController extends AsdhController {
	private $prefix = 'news-feed';
	private $viewPath = 'admin.news-feed';

	public function __construct() {
		parent::__construct();
		$this->website['routeType'] = 'news-feed';
	}

	public function index(Request $request) {
		$queryType = $request->query('type');
		if(!is_null($queryType) && $queryType !== 'video' && $queryType !== 'gallery') {
			return back()->with('failure_message', 'Not allowed');
		}

		switch($queryType) {
			case 'video':
				$this->website['models'] = NewsFeed::video()->get();
				break;
			case 'gallery':
				$this->website['models'] = NewsFeed::gallery()->get();
				break;
			default:
				$this->website['models'] = NewsFeed::news()->get();
		}

		return view("{$this->viewPath}.index", $this->website);
	}

	public function create(Request $request) {
		$queryType = $request->query('type');
		
		if(!is_null($queryType) && $queryType !== 'video' && $queryType !== 'gallery') {
			return back()->with('failure_message', 'Not allowed');
		}
		$this->website['edit'] = false;

		return view("{$this->viewPath}.create", $this->website);
	}

	public function store(NewsFeedRequest $request) {
		$queryType = $request->query('type');
		if(!is_null($queryType) && $queryType !== 'video' && $queryType !== 'gallery') {
			return back()->with('failure_message', 'Not allowed');
		}

		DB::transaction(function() use ($request, $queryType) {
			$newsFeed = NewsFeed::create([
				'title'       => $request->input('title'),
				'slug'        => $request->input('slug'),
				'description' => $request->input('description'),
				'youtube_url' => $request->input('url'),
				'type'        => $queryType ?: 'news',
			]);

			if(!is_null($request->file('image'))) {
				$imageName = upload_image_modified($request->file('image'), $this->prefix);
				$newsFeed->images()->create(['image' => $imageName]);
			}

			$this->insertMultipleImagesIfPresent($request, $newsFeed);
		});

		return redirect()->route($this->website['routeType'] . '.index', ['type' => $queryType])
		                 ->with('success_message', 'NewsFeed successfully added.');
	}

	public function edit(Request $request, NewsFeed $newsFeed) {
		$queryType = $request->query('type');
		if(!is_null($queryType) && $queryType !== 'video' && $queryType !== 'gallery') {
			return back()->with('failure_message', 'Not allowed');
		}

		$this->website['edit']  = true;
		$this->website['model'] = $newsFeed;

		return view("{$this->viewPath}.create", $this->website);
	}

	public function update(Request $request, NewsFeed $newsFeed) {
		$queryType = $request->query('type');
		if(!is_null($queryType) && $queryType !== 'video' && $queryType !== 'gallery') {
			return back()->with('failure_message', 'Not allowed');
		}

		DB::transaction(function() use ($newsFeed, $request, $queryType) {
			$newsFeed->update([
				'title'       => $request->input('title'),
				'slug'        => $request->input('slug'),
				'description' => $request->input('description'),
				'youtube_url' => $request->input('url'),
				'type'        => $queryType ?: 'news',
			]);

			if(!is_null($request->file('image'))) {
				$imageName     = upload_image_modified($request->file('image'), $this->prefix);
				$newsFeedImage = $newsFeed->images->first();
				if($newsFeedImage) {
					$newsFeedImage->delete_image();
					$newsFeedImage->update(['image' => $imageName]);
				} else {
					$newsFeed->images()->create(['image' => $imageName]);
				}
			}

			$this->insertMultipleImagesIfPresent($request, $newsFeed);
		});

		return redirect()->route($this->website['routeType'] . '.index', ['type' => $queryType])
		                 ->with('success_message', 'NewsFeed successfully updated.');
	}

	public function destroy(NewsFeed $newsFeed) {
		if($newsFeed->delete()) {
			foreach($newsFeed->images as $image) {
				$image->delete_image();
				$image->delete();
			}

			return back()->with('success_message', 'NewsFeed successfully deleted.');
		}

		return back()->with('failure_message', 'NewsFeed could not be deleted. Please try again later.');
	}

	private function insertMultipleImagesIfPresent(Request $request, NewsFeed $newsFeed) {
		if(!is_null($request->file('images'))) {
			$inputImages = [];
			foreach($request->file('images') as $image) {
				$imageName     = upload_image_modified($image, $this->prefix);
				$inputImages[] = ['image' => $imageName];
			}
			$newsFeed->images()->createMany($inputImages);
		}
	}
}
