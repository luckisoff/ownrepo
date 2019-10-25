<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\QuestionType;
class QuestionTypeController extends AsdhController
{

    protected $prefix='question-type';

    public function __construct() {
		ini_set('memory_limit', '-1');
		parent::__construct();
		$this->website['routeType'] = 'question-type';
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->website['models'] = QuestionType::withCount('question')->latest()->paginate($this->default_pagination_limit);
		return view('admin.questiontype.index', $this->website);   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->website['edit'] = false;
		return view('admin.questiontype.create', $this->website);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return QuestionType::create([
			'name'          => $request->name,
			'point'          => $request->point?$request->point:0,
		])
			? redirect('admin/question-type')->with('success_message', 'Question Type successfully added.')
			: back()->with('failure_message', 'Question Type could not be added. Please try again later.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(QuestionType $questionType)
    {
        $this->website['routeType']    = 'question';
		$this->website['setquestion'] = $questionType;
		$this->website['models']       = $questionType->question()->paginate($this->default_pagination_limit);

		return view('admin.question.index', $this->website);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(QuestionType $questionType)
    {
        $this->website['edit']  = true;

		$this->website['model'] = $questionType;
		
		return view('admin.questiontype.create', $this->website);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuestionType $questionType)
    {
        return $questionType->update([
			'name'          => $request->name,
			'point' => $request->point,
		])
			? redirect('admin/question-type')->with('success_message', 'Type successfully updated.')
			: back()->with('failure_message', 'Type could not be updated. Please try again later.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $questiontype=QuestionType::findOrFail($id);
        if($questiontype->delete()) {
			return back()->with('success_message', 'Question Type deleted!');
		}

		return back()->with('failure_message', 'Question type could not be deleted!');
    }
}
