<?php

namespace App\Http\Controllers;

use App\FastestFingerFirstOption;
use App\FastestFingerFirstQuestion;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FastestFingerFirstQuestionController extends AsdhController {
	private $viewPath = 'admin.question.f3';

	public function __construct() {
		parent::__construct();
		$this->website['routeType'] = 'f-question';
	}

	public function index() {
		$this->website['models'] = FastestFingerFirstQuestion::latest()->paginate($this->default_pagination_limit);

		return view("{$this->viewPath}.index", $this->website);
	}

	public function create() {
		$this->website['edit'] = false;

		return view("{$this->viewPath}.create", $this->website);
	}

	public function store(Request $request) {
		DB::transaction(function() use ($request) {
			$fffQuestion = FastestFingerFirstQuestion::create([
				'question' => $request->input('question'),
			]);

			$fffQuestion->conversions()->create([
				'language_id' => 1,
				'question'    => $request->input('question_nepali'),
			]);

			foreach($request->input('options') as $key => $option) {
				$option = FastestFingerFirstOption::create([
					'question_id' => $fffQuestion->id,
					'option'      => $request->input('options')[ $key ],
					'order'       => $key + 1,
				]);

				$option->conversions()->create([
					'language_id' => '1',
					'option'      => $request->input('options_nepali')[ $key ],
				]);
			}
		});

		return redirect()->route($this->website['routeType'] . '.index')->with('success_message', 'Question successfully added.');
	}

	public function edit(FastestFingerFirstQuestion $fQuestion) {
		$this->website['edit']  = true;
		$this->website['model'] = $fQuestion;

		return view("{$this->viewPath}.create", $this->website);
	}

	public function update(Request $request, FastestFingerFirstQuestion $fQuestion) {
		DB::transaction(function() use ($fQuestion, $request) {
			$fQuestion->update([
				'question' => $request->input('question'),
			]);

			if(count($fQuestion->conversions)) {
				$fQuestion->conversions()->update([
					'question'    => $request->input('question_nepali'),
					'language_id' => '1',
				]);
			} else {
				$fQuestion->conversions()->create([
					'question'    => $request->input('question_nepali'),
					'language_id' => '1',
				]);
			}

			foreach($fQuestion->options as $key => $option) {
				$option->update([
					'option' => $request->input('options')[ $key ],
				]);

				if(count($option->conversions)) {
					$option->conversions()->update([
						'option'      => $request->input('options_nepali')[ $key ],
						'language_id' => '1',
					]);
				} else {
					$option->conversions()->create([
						'option'      => $request->input('options_nepali')[ $key ],
						'language_id' => '1',
					]);
				}
			}
		});

		return back()->with('success_message', 'Question successfully updated.');
	}

	public function destroy(FastestFingerFirstQuestion $fQuestion) {
		if($fQuestion->delete()) {
			return back()->with('success_message', 'Question successfully deleted.');
		}

		return back()->with('failure_message', 'Question could not be deleted. Please try again later.');
	}
}
