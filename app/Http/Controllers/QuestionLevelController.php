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
use App\Level;
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

	public function questions($country=1) {
		
		$setquestion=Setquestion::with(['question'=>function($q){
			$q->with(['setquestion','questionType']);
		}])->orderby('updated_at','asc')->limit(1)->get()->pluck('question')->random();
		//$questions=Question::with(['setquestion','questionType'])->orderBy('created_at','desc')->get()->take(15);
		
		// return Setquestion::with(['question'=>function($q){
		// 	$q->with('options');
		// }])->whereHas('question')->where('question_type_id',$country)->random()->first();

		$return_data = $this->format_multi_lang($setquestion);

		return response()->json(['status' => true, 'code' => 200, 'data' => $return_data], 200);
	}

	public function test($user_id='',$level=1) {
		
		// $setquestion=Setquestion::with(['question'=>function($q){
		// 	$q->with(['setquestion','questionType']);
		// }])->orderby('updated_at','asc')->limit(1)->get()->pluck('question')->random();
		//$questions=Question::with(['setquestion','questionType'])->orderBy('created_at','desc')->get()->take(15);
		$levelPlayed=Level::where('user_id',$user_id)->pluck('setquestion_id')->toArray();
		
		if(!empty($levelPlayed)){
			$setWithQuestion=Setquestion::where('question_type_id',$level)->whereHas('question')->with(['question'=>function($q){
				$q->with('options');
			}])->get();
			foreach($setWithQuestion as $setquestion){
				if(in_array($setquestion->id,$levelPlayed)){
					$setWithQuestion=$setquestion;
				}
			}
		}else{
			$setWithQuestion=Setquestion::where('question_type_id',$level)->whereHas('question')->with(['question'=>function($q){
				$q->with('options');
			}])->first();
		}
		
		
		Level::create([
			'user_id'=>$user_id,
			'setquestion_id'=>$setWithQuestion->id
		]);
		return $setWithQuestion;
		// $return_data = $this->format_multi_lang($setquestion);

		// return response()->json(['status' => true, 'code' => 200, 'data' => $return_data], 200);
	}
	
	public function format_multi_lang($questions) {
	    
		$return_data = [];
		$i=0;
		foreach($questions as $question) {
		    
			$return_data['english'][] = [
				'questionId' => $question->id,
				'question'   => $question->name,
				'set'       =>$question->setquestion['name'],
				'type'      =>$question->questionType['name'],
				'point'     =>$question->questionType['point'],
				'country'	=>$question->country,
				'options'    => $question->options()->select('name', 'answer')->get()->shuffle()->toArray(),
			];
			$return_data['nepali'][]  = [
				
				'id'       => $question->id,
				'question' => $question->nepali()->name,
				'set'       =>$question->setquestion['name'],
				'type'      =>$question->questionType['name'],
				'point'     =>$question->questionType['point'],
				'country'	=>$question->country,
				'options'  => $question->options_nepali(),
			];
		}

		return $return_data;
	}


}
