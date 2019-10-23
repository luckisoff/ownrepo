<?php

namespace App\Http\Controllers\Api;

use App\QuestionSetCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;


class QuizController extends Controller
{
    public function getRandomQuestion(){
        // get today's question set collection
        $question_set_collection = QuestionSetCollection::where('show_on', Carbon::today())->first();
//        dd($question_set_collection);

        if(is_null($question_set_collection)) {
            return response()->json([
                'status'  => false,
                'code'    => 400,
                'message' => 'No question set collection is assigned for today',
            ], 400);
        }

        // get a random set from the collection
        $random_question_set = $question_set_collection->question_sets->random();
//        dd($random_question_set);
        // get 5 random questions from the set
        $random_questions = $random_question_set->questions->shuffle()->take(5);
        // format according to English and Nepali language
        $return_data = $this->format_according_to_multi_language($random_questions);

        return response()->json(['status' => true, 'code' => 200, 'data' => $return_data], 200);
    }

    public function format_according_to_multi_language($questions) {
        $return_data = [];
        foreach($questions as $question) {
            $return_data['english'][] = [
                'questionId' => $question->id,
                'question'   => $question->name,
                'type'       => $question->type,
                'file'       => $question->type == 'audio' ? $question->file : null,
//                'price'      => $question->difficulty_level->price,
//                'duration'   => $question->difficulty_level->duration,
                'options'    => $question->options()->select('name', 'answer')->get()->shuffle()->toArray(),
            ];
            $return_data['nepali'][]  = [
                'id'       => $question->id,
                'question' => $question->nepali()->name,
                'type'     => $question->type,
                'file'     => $question->type == 'audio' ? $question->file : null,
//                'price'    => $question->difficulty_level->price,
//                'duration' => $question->difficulty_level->duration,
                'options'  => $question->options_nepali(),
            ];
        }

        return $return_data;
    }
}
