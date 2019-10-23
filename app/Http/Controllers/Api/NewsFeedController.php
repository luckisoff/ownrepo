<?php

namespace App\Http\Controllers\Api;

use App\Advertisement;
use App\Http\Resources\NewsFeedResource;
use App\NewsFeed;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class NewsFeedController extends Controller {
	public function index() {
		// $newsFeeds = NewsFeed::latest()->paginate(20);
		$newsFeeds = NewsFeed::latest()->get();

		$response = NewsFeedResource::collection($newsFeeds);

		return $response->additional([
			'advertisements'        => Advertisement::category(4)->pluck('image')->toArray(),
			'advertisementsWithUrl' => Advertisement::category(4)->select('image', 'url')->get()->toArray(),
			'status'                => true,
			'code'                  => Response::HTTP_OK,
		])->response()->setStatusCode(Response::HTTP_OK);
	}
}
