<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Leaderboard;
use App\User;
class LeaderboardController extends AsdhController {


    public function save_user_points(Request $request){
        $leaderboard=Leaderboard::where('user_id',$request->user_id)->select('id','user_id','point')->first();

        $user =User::findOrFail($leaderboard->user_id);
            if($leaderboard){
                $leaderboard->point += $request->point;
                $leaderboard->update();
                return $user->leaderboards;
            }
        }
    }
