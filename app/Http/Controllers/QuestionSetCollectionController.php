<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionSetCollectionRequest;
use App\QuestionSet;
use App\QuestionSetCollection;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QuestionSetCollectionController extends AsdhController {
	private $prefix = 'question-set-collection-collection';

	public function __construct() {
		parent::__construct();
		$this->website['routeType'] = 'question-set-collection';
	}

	public function index() {
		$this->website['models'] = QuestionSetCollection::orderBy('show_on', 'desc')->paginate($this->default_pagination_limit);

		return view('admin.question-set-collection.index', $this->website);
	}

	public function create() {
		$this->website['edit'] = false;

		return view('admin.question-set-collection.create', $this->website);
	}

	public function store(QuestionSetCollectionRequest $request) {
		$sponser_image_name = null;
		if(!is_null($request->sponser_image)) {
			$sponser_image_name = upload_image_modified($request->sponser_image, $this->prefix);
		}
		$icon = null;
		if(!is_null($request->icon)) {
			$icon = upload_image_modified($request->icon, $this->prefix);
		}

		return QuestionSetCollection::create([
			'title'          => $request->title,
			'sponser_status' => 0,
			'sponser_image'  => $sponser_image_name,
			'icon'           => $icon,
			'color'          => $request->color,
			'show_on'        => Carbon::parse($request->show_on),
		])
			? back()->with('success_message', 'QuestionSetCollection successfully added.')
			: back()->with('failure_message', 'QuestionSetCollection could not be added. Please try again later.');
	}

	public function show(QuestionSetCollection $question_set_collection) {
		$this->website['question_set_collection'] = $question_set_collection;
		$this->website['question_sets']           = QuestionSet::get();

		return view('admin.question-set-collection.show', $this->website);
	}

	public function add_question_sets_to_collection(Request $request, QuestionSetCollection $question_set_collection) {
		$request->validate([
			'question_set_ids'   => 'required|array',
			'question_set_ids.*' => 'required|integer|min:1',
		], [
			'question_set_ids.required' => 'Choose at least one question set',
		]);

		$question_set_collection->question_sets()->sync($request->question_set_ids);

		return back()->with('success_message', 'Question sets successfully added');
	}

	public function edit(QuestionSetCollection $question_set_collection) {
		$this->website['edit']  = true;
		$this->website['model'] = $question_set_collection;

		return view('admin.question-set-collection.create', $this->website);
	}

	public function update(QuestionSetCollectionRequest $request, QuestionSetCollection $question_set_collection) {

		$sponser_image_name = $question_set_collection->getOriginal('sponser_image');
		if(!is_null($request->sponser_image)) {
			$question_set_collection->delete_image('sponser_image');
			$sponser_image_name = upload_image_modified($request->sponser_image, $this->prefix);
		}
		$icon = $question_set_collection->getOriginal('icon');
		if(!is_null($request->icon)) {
			$question_set_collection->delete_image('icon');
			$icon = upload_image_modified($request->icon, $this->prefix);
		}

		return $question_set_collection->update([
			'title'          => $request->title,
			'sponser_status' => 0,
			'sponser_image'  => $sponser_image_name,
			'icon'           => $icon,
			'color'          => $request->color,
			'show_on'        => Carbon::parse($request->show_on),
		])
			? back()->with('success_message', 'QuestionSetCollection successfully updated.')
			: back()->with('failure_message', 'QuestionSetCollection could not be updated. Please try again later.');
	}

	public function destroy(QuestionSetCollection $question_set_collection) {
		if($question_set_collection->delete()) {
			$question_set_collection->delete_image('sponser_image');
			$question_set_collection->delete_image('icon');

			return back()->with('success_message', 'QuestionSetCollection successfully deleted.');
		}

		return back()->with('failure_message', 'QuestionSetCollection could not be deleted. Please try again later.');
	}
}
