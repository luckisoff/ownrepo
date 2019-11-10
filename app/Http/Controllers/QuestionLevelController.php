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

	// public function questions($country=1) {
		
	// 	$setquestion=Setquestion::with(['question'=>function($q){
	// 		$q->with(['setquestion','questionType']);
	// 	}])->orderby('updated_at','asc')->limit(1)->get()->pluck('question')->random();
	// 	//$questions=Question::with(['setquestion','questionType'])->orderBy('created_at','desc')->get()->take(15);
		
	// 	// return Setquestion::with(['question'=>function($q){
	// 	// 	$q->with('options');
	// 	// }])->whereHas('question')->where('question_type_id',$country)->random()->first();

	// 	$return_data = $this->format_multi_lang($setquestion);

	// 	return response()->json(['status' => true, 'code' => 200, 'data' => $return_data], 200);
	// }

	public function questions($user_id='',$type_id=1) {
		$levelPlayed=Level::where('user_id',$user_id)->pluck('setquestion_id')->toArray();
		if($levelPlayed){
			$setWithQuestion=Setquestion::where('question_type_id',$type_id)->whereHas('question')->with('question')->inRandomOrder()->get();
			$setWithQuestion=$setWithQuestion->except($levelPlayed)->first();
		}else{
			$setWithQuestion=Setquestion::where('question_type_id',$type_id)->whereHas('question')->with('question')->inRandomOrder()->first();
		}
		
		if(!$setWithQuestion){
			return response()->json([
				'status'=>false,
				'message'=>'error',
				'data'	=>'No Questions Available for Now.'
			]);
		}
		 $return_data = $this->format_multi_lang($setWithQuestion->question->random(15));
		 return response()->json([
			 'status' => true, 
			 'code' => 200, 
			 'set_id'=>$setWithQuestion->id,
			 'set_type'=> $setWithQuestion->questionType->name,
			 'data' => $return_data], 200);
	}


	public function setLevel(Request $request){
		if(empty($request->user_id) || empty($request->set_id)){
			return ["status"=>false,'message'=>'missing parametes','data'=>''];
		}

		$level=Level::where('user_id',$request->user_id)->where('setquestion_id',$request->set_id)->first();
		if($level){
			return ["status"=>false,'message'=>'This set is already payed','data'=>''];
		}
		$level=new Level();
		$level->user_id=$request->user_id;
		$level->setquestion_id=$request->set_id;
		$level->save();
		return ["status"=>true,'message'=>'Played set stored','data'=>''];
	}


	public function format_multi_lang($questions) {
	    
		$return_data = [];
		$i=0;
		foreach($questions as $question) {
		    
			$return_data['english'][] = [
				'questionId' => $question->id,
				'question'   => $question->name,
				'set'       =>$question->setquestion['name'],
				
				'point'     =>$question->questionType['point'],
				'country'	=>$question->country,
				'options'    => $question->options()->select('name', 'answer')->get()->shuffle()->toArray(),
			];
			$return_data['nepali'][]  = [
				
				'id'       => $question->id,
				'question' => $question->nepali()->name,
				'set'       =>$question->setquestion['name'],
				'point'     =>$question->questionType['point'],
				'country'	=>$question->country,
				'options'  => $question->options_nepali(),
			];
		}

		return $return_data;
	}


}
