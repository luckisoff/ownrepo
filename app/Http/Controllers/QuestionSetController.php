<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionSetRequest;
use App\QuestionSet;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QuestionSetController extends AsdhController {
	private $prefix = 'question-set';

	public function __construct() {
		parent::__construct();
		$this->website['routeType'] = 'question-set';
	}

	public function index() {
		$this->website['models'] = QuestionSet::withCount('questions')->latest()->paginate($this->default_pagination_limit);
		
		return view('admin.question-set.index', $this->website);
	}

	public function create() {
		$this->website['edit'] = false;

		return view('admin.question-set.create', $this->website);
	}

	public function store(QuestionSetRequest $request) {
		$startTime = Carbon::parse($request->start_time);
		$endTime   = Carbon::parse($request->end_time);

		$questionSetInRange = QuestionSet::where(function($query) use ($startTime, $endTime) {
			$query->whereBetween('start_time', [$startTime, $endTime]);
		})
		                                 ->orWhere(function($query) use ($startTime, $endTime) {
			                                 $query->whereBetween('end_time', [$startTime, $endTime]);
		                                 })
		                                 ->orWhere(function($query) use ($startTime) {
			                                 $query->where('start_time', '<=', $startTime)
			                                       ->where('end_time', '=>', $startTime);
		                                 })
		                                 ->orWhere(function($query) use ($endTime) {
			                                 $query->where('start_time', '<=', $endTime)
			                                       ->where('end_time', '=>', $endTime);
		                                 })
		                                 ->first();

		if($questionSetInRange) {
			return back()->with('failure_message', 'Question set "' . $questionSetInRange->title . '" is in this time range.');
		}

		$sponser_image_name = null;
		if(!is_null($request->sponser_image)) {
			$sponser_image_name = upload_image_modified($request->sponser_image, $this->prefix);
		}
		$icon = null;
		if(!is_null($request->icon)) {
			$icon = upload_image_modified($request->icon, $this->prefix);
		}

		return QuestionSet::create([
			'title'          => $request->title,
			'sponser_status' => 0,
			'sponser_image'  => $sponser_image_name,
			'icon'           => $icon,
			'color'          => $request->color,
			'start_time'     => $startTime,
			'end_time'       => $endTime,
		])
			? back()->with('success_message', 'QuestionSet successfully added.')
			: back()->with('failure_message', 'QuestionSet could not be added. Please try again later.');
	}

	public function show(QuestionSet $question_set) {
		$this->website['routeType']    = 'question';
		$this->website['question_set'] = $question_set;
		$this->website['models']       = $question_set->questions()->paginate($this->default_pagination_limit);

		return view('admin.question.index', $this->website);
	}

	public function edit(QuestionSet $question_set) {
		$this->website['edit']  = true;
		$this->website['model'] = $question_set;

		return view('admin.question-set.create', $this->website);
	}

	public function update(QuestionSetRequest $request, QuestionSet $question_set) {
		$startTime = Carbon::parse($request->start_time);
		$endTime   = Carbon::parse($request->end_time);

		$questionSetInRange = QuestionSet::where('id', '!=', $question_set->id)
		                                 ->where(function($query) use ($startTime, $endTime) {
			                                 $query
				                                 ->where(function($query) use ($startTime, $endTime) {
					                                 $query->whereBetween('start_time', [$startTime, $endTime]);
				                                 })
				                                 ->orWhere(function($query) use ($startTime, $endTime) {
					                                 $query->whereBetween('end_time', [$startTime, $endTime]);
				                                 })
				                                 ->orWhere(function($query) use ($startTime) {
					                                 $query->where('start_time', '<=', $startTime)
					                                       ->where('end_time', '=>', $startTime);
				                                 })
				                                 ->orWhere(function($query) use ($endTime) {
					                                 $query->where('start_time', '<=', $endTime)
					                                       ->where('end_time', '=>', $endTime);
				                                 });
		                                 })
		                                 ->first();

		if($questionSetInRange) {
			return back()->with('failure_message', 'Question set "' . $questionSetInRange->title . '" is in this time range.');
		}

		$sponser_image_name = $question_set->getOriginal('sponser_image');
		if(!is_null($request->sponser_image)) {
			$question_set->delete_image('sponser_image');
			$sponser_image_name = upload_image_modified($request->sponser_image, $this->prefix);
		}
		$icon = $question_set->getOriginal('icon');
		if(!is_null($request->icon)) {
			$question_set->delete_image('icon');
			$icon = upload_image_modified($request->icon, $this->prefix);
		}

		return $question_set->update([
			'title'          => $request->title,
			'sponser_status' => 0,
			'sponser_image'  => $sponser_image_name,
			'icon'           => $icon,
			'color'          => $request->color,
			'start_time'     => $startTime,
			'end_time'       => $endTime,
		])
			? back()->with('success_message', 'QuestionSet successfully updated.')
			: back()->with('failure_message', 'QuestionSet could not be updated. Please try again later.');
	}

	public function destroy(QuestionSet $question_set) {
		if($question_set->delete()) {
			$question_set->delete_image('sponser_image');
			$question_set->delete_image('icon');

			return back()->with('success_message', 'QuestionSet successfully deleted.');
		}

		return back()->with('failure_message', 'QuestionSet could not be deleted. Please try again later.');
	}
}
