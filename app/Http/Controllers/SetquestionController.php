<?php

namespace App\Http\Controllers;

use App\Http\Requests\SetQuestionRequest;
use Illuminate\Http\Request;
use App\Setquestion;
class SetquestionController extends AsdhController
{
    protected $prefix='setquestion';

    public function __construct() {
		ini_set('memory_limit', '-1');
		parent::__construct();
		$this->website['routeType'] = 'setquestion';
    }
    
    public function index() {
		$this->website['models'] = Setquestion::withCount('question')->latest()->paginate($this->default_pagination_limit);
		return view('admin.setquestion.index', $this->website);
	}

	public function create() {
		$this->website['edit'] = false;
		return view('admin.setquestion.create', $this->website);
	}

	public function show(Setquestion $setquestion){
		$this->website['routeType']    = 'question';
		$this->website['setquestion'] = $setquestion;
		$this->website['models']       = $setquestion->question()->paginate($this->default_pagination_limit);

		return view('admin.question.index', $this->website);
	}

	public function store(SetQuestionRequest $request) {

		return Setquestion::create([
			'name'          => $request->name,
			'price'          => $request->price?$request->price:0,
			'status'        => 1,
		])
			? redirect('admin/setquestion')->with('success_message', 'Question Set successfully added.')
			: back()->with('failure_message', 'Question Set could not be added. Please try again later.');
	}

	public function edit(Setquestion $setquestion) {
		$this->website['edit']  = true;

		$this->website['model'] = $setquestion;
		
		return view('admin.setquestion.create', $this->website);
	}

	public function update(SetQuestionRequest $request, Setquestion $setquestion) {
		return $setquestion->update([
			'name'          => $request->name,
			'status' => $request->status,
			'price'          => $request->price,
		])
			? redirect('admin/setquestion')->with('success_message', 'Set successfully updated.')
			: back()->with('failure_message', 'Set could not be updated. Please try again later.');
	}

	public function destroy(Setquestion $setquestion) {
		if($setquestion->delete()) {
			return back()->with('success_message', 'Set successfully deleted.');
		}

		return back()->with('failure_message', 'Set could not be deleted. Please try again later.');
	}
}
