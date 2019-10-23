<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SetquestionController extends AsdhController
{
    protected $prefix='setquestion';

    public function __construct() {
		ini_set('memory_limit', '-1');
		parent::__construct();
		$this->website['routeType'] = 'setquestion';
    }
    
    public function index() {
		$this->website['models'] = Question::offline()->with('difficulty_level')->latest()->paginate($this->default_pagination_limit);
		// $this->website['models']            = Question::offline()->with('difficulty_level')->latest()->get();
		$this->website['difficulty_levels'] = DifficultyLevel::select('id', 'level')->orderBy('level')->get();

		return view('admin.question.index', $this->website);
	}

	public function create() {
		$this->website['edit'] = false;
		// if create question is clicked from question set index page
		if(!request()->has('sponsor_id')) {
			if(request()->has('question_set_id')) {
				$this->website['current_question_set'] = QuestionSet::find(request()->question_set_id);
				$this->website['question_sets']        = QuestionSet::get();
			} else {
				$this->website['difficulty_levels'] = DifficultyLevel::orderBy('level')->get();
				$this->website['categories']        = Category::orderBy('name')->get();
			}
		} else {
			$this->website['sponsors'] = Sponsor::select('id', 'name')->get();
		}

		return view('admin.question.create', $this->website);
	}

	public function store(QuestionRequest $request) {
		
	}

	public function edit(Question $question) {
		
	}

	public function update(QuestionRequest $request, Question $question) {
		
	}

	public function destroy() {
		
	}
}
