<?php

namespace App\Http\Controllers;

use App\Category;
use App\DifficultyLevel;
use App\Http\Requests\QuestionRequest;
use App\Option;
use App\OptionConversion;
use App\Question;
use App\QuestionSet;
use App\Sponsor;
use App\Setquestion;
use App\QuestionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class QuestionController extends AsdhController {
	private $prefix = 'question';
	protected $excel;
	public function __construct() {
		ini_set('memory_limit', '-1');
		parent::__construct();
		$this->website['routeType'] = 'question';
	}

	public function index() {
		$this->website['models'] = Question::offline()->with('difficulty_level')->latest()->paginate($this->default_pagination_limit);
		// $this->website['models']            = Question::offline()->with('difficulty_level')->latest()->get();
		$this->website['difficulty_levels'] = DifficultyLevel::select('id', 'level')->orderBy('level')->get();
		
// 		foreach($this->website['models'] as $question){
		    
// 		    if(!$question->question_type_id){
// 		        $question->question_type_id=1;
// 		        $question->update();
// 		    }
// 		}
        
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

		$this->website['setquestion']=Setquestion::select('id','name')->orderBy('created_at','asc')->get();
		$this->website['questiontype']=QuestionType::select('id','name')->orderBy('created_at','asc')->get();
		
		return view('admin.question.create', $this->website);
	}

	public function store(QuestionRequest $request) {
		$question = new Question();
		if(!$request->has('sponsor_id')) {
			// if create question is clicked from question set index page
			if($request->has('question_set_id')) {
				$question->question_set_id = $request->question_set_id;
				$question->online          = true;
			} else {
				$question->setquestion_id	= $request->setquestion_id;
				$question->category_id         = $request->category_id;
				$question->difficulty_level_id = $request->difficulty_level_id;
				$question->online              = false;
			}
		} else {
			$question->online     = true;
			$question->sponsor_id = $request->sponsor_id;
		}
		$question->name = $request->question;
		$question->type = $request->question_type;
		$question->question_type_id=$request->question_type_id;
		if(!is_null($request->question_file)) {
			$question->file = upload_file($request->question_file, $this->prefix . '-' . $request->question_type);
		}

		$question->save();
		$question->conversions()->create([
			'language_id' => '1',
			'name'        => $request->question_nepali,
		]);

		foreach($request->options as $key => $option) {
			$new_option = Option::create([
				'question_id' => $question->id,
				'name'        => $option,
				'answer'      => $key == $request->answer ? 1 : 0,
			]);

			$new_option->conversions()->create([
				'language_id' => '1',
				'name'        => $request->options_nepali[ $key ],
			]);
		}

		return back()->with('success_message', 'Question and answers successfully added.');
	}

	public function edit(Question $question) {
		$this->website['edit']  = true;
		$this->website['model'] = $question;

		if(!request()->has('sponsor_id')) {
			// if create question is clicked from question set index page
			if(request()->has('question_set_id')) {
				$this->website['question_sets']        = QuestionSet::get();
				$this->website['current_question_set'] = $question;
			} else {
				$this->website['difficulty_levels'] = DifficultyLevel::orderBy('level')->get();
				$this->website['categories']        = Category::orderBy('name')->get();
				$this->website['setquestion']	=Setquestion::all();
				$this->website['questiontype']    =QuestionType::all();
			}
		} else {
			$this->website['sponsors'] = Sponsor::select('id', 'name')->get();
		}

		return view('admin.question.create', $this->website);
	}

	public function update(QuestionRequest $request, Question $question) {
		// if create question is clicked from question set index page

		if(!$request->has('sponsor_id')) {
			if($request->has('question_set_id')) {
				$question->question_set_id = $request->question_set_id;
			} else {
				$question->setquestion_id=$request->setquestion_id;
				$question->category_id         = $request->category_id;
				$question->difficulty_level_id = $request->difficulty_level_id;
			}
		} else {
			$question->sponsor_id = $request->sponsor_id;
		}
		$question->name = $request->question;
		if($request->question_type == 'text') {
			$question->delete_file();
			$question->file = null;
		}
		$question->type = $request->question_type;
        $question->question_type_id=$request->question_type_id;
		if(!is_null($request->question_file)) {
			$question->delete_file();
			$question->file = upload_file($request->question_file, $this->prefix . '-' . $request->question_type);
		}

		$question->save();
		$question->conversions()->update([
			'language_id' => '1',
			'name'        => $request->question_nepali,
		]);

		foreach($question->options as $key => $option) {
			$option->update([
				'name'   => $request->options[ $key ],
				'answer' => $key == $request->answer ? 1 : 0,
			]);

			$option->conversions()->update([
				'language_id' => '1',
				'name'        => $request->options_nepali[ $key ],
			]);
		}

		return redirect('admin/question')->with('success_message', 'Question and answers successfully added.');
	}

	public function destroy(Question $question) {
		if($question->delete()) {
			return back()->with('success_message', 'Question successfully deleted.');
		}

		return back()->with('failure_message', 'Question could not be deleted. Please try again later.');
	}

	public function excelUpload() {
		return view('admin.question.excel-upload', $this->website);
	}

	public function getsetid($name,$qtype){
		$set=Setquestion::where('name',$name)->first();
		
		$questiontype=\App\QuestionType::where('name',$qtype)->first();
		
		if(!$questiontype){
		    $questiontype=new \App\QuestionType();
		    $questiontype->name=$qtype;
		    $questiontype->point=1;
		    $questiontype->save();
		}
		
		if($set){
		    return array('set_id'=>$set->id,'type_id'=>$questiontype->id);
		}
		
		$set=new Setquestion();
		$set->name=$name;
		$set->question_type_id=$questiontype->id;
		$set->status=1;
		$set->save();
		return array('set_id'=>$set->id,'type_id'=>$questiontype->id);
		
	}
	public function excelUploadStore(Request $request) {
		Excel::load($request->excel_file, function($reader) {
			$reader->each(function($sheet) {
				DB::transaction(function() use ($sheet) {
					$category=$sheet->category!=''?$sheet->category:'General';
					$category = Category::firstOrCreate(['name' => $category], ['slug' => asdh_str_slug($category)]);

					// save question to database
					$question                      = new Question;
					$question->difficulty_level_id = $sheet->dificulty_level;
					$question->category_id         = $category->id;
					$question->name                = $sheet->question_eng;
					$question->type                = 'text';
					$question->online              = 0;
					
					$setNtype=$this->getsetid($sheet->set_name,$sheet->set_type);
					
					$question->setquestion_id=$setNtype['set_id'];
					$question->question_type_id=$setNtype['type_id'];
					
			
					$question->save();

					//convert question to nepali and save to database
					$question->conversions()->create([
						'language_id' => '1',
						'name'        => $sheet->question_nep,
					]);

					//save options to database
					foreach(range(1, 4) as $item) {
						$attribute       = 'option_' . $item;
						$attributeNepali = 'option_' . $item . '_nep';

						$option = Option::create([
							'question_id' => $question->id,
							'name'        => $sheet->$attribute,
							'answer'      => $sheet->$attribute==$sheet->answer_eng?1:0,
						]);

						$option->conversions()->create([
							'language_id' => '1',
							'name'        => $sheet->$attributeNepali,
						]);
					}
				});
			});
		});
		
		return back()->with('success_message', 'Question form file successfully uploaded');
	}
}
