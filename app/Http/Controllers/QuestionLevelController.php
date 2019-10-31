<?php

namespace App\Http\Controllers;

use App\Advertisement;
use App\Category;
use App\Device;
use App\DifficultyLevel;
use App\Exceptions\SocialLoginException;
use App\FastestFingerFirstQuestion;
use App\Http\Controllers\Api\CommonController;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserResourceCollection;
use App\Leaderboard;
use App\Mail\VerifyEmail;
use App\Option;
use App\Question;
use App\QuestionSet;
use App\QuestionSetCollection;
use App\Role;
use App\Setting;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\Response;
use App\Setquestion;
class QuestionLevelController extends CommonController {
	public function __construct() {
		parent::__construct();
	}



	protected function my_validation($validation, $messages = []) {
		$validator = Validator::make(request()->all(), $validation, $messages);
		if($validator->fails()) {
			return ['status' => false, 'message' => $validator->errors()->all()];
		}

		return ['status' => true];
	}

	public function questions() {
		$setquestion=Setquestion::with(['question'=>function($q){
			$q->with(['setquestion','questionType']);
		}])->orderby('updated_at','asc')->get()->pluck('question')->flatten();
        $questions=Question::with(['setquestion','questionType'])->orderBy('created_at','desc')->get()->take(15);
		
		$return_data = $this->format_multi_lang($setquestion);

		return response()->json(['status' => true, 'code' => 200, 'data' => $return_data], 200);
	}
	
	public function format_multi_lang($questions) {
	    
		$return_data = [];
		foreach($questions as $question) {
		    
			$return_data['english'][] = [
				'questionId' => $question->id,
				'question'   => $question->name,
				'set'       =>$question->setquestion['name'],
				'type'      =>$question->questionType['name'],
				'point'     =>$question->questionType['point'],
				'options'    => $question->options()->select('name', 'answer')->get()->shuffle()->toArray(),
			];
			$return_data['nepali'][]  = [
				'id'       => $question->id,
				'question' => $question->nepali()->name,
				'set'       =>$question->setquestion['name'],
				'type'      =>$question->questionType['name'],
				'point'     =>$question->questionType['point'],
				'options'  => $question->options_nepali(),
			];
		}

		return $return_data;
	}


}
