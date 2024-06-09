<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\Rest;
use App\Models\User;
use Carbon\Carbon;

class RestController extends Controller
{
    // 休憩開始処理
    public function startRest(Request $request){
        $user = Auth::user();

        $oldTimestamp = Attendance::where('user_id',$user->id)->latest()->first();

        if(!$oldTimestamp){
            $oldTimestamp = Attendance::create([
                'user_id' => $user->id,
                'start_time' => Carbon::now(),
            ]);
        }

        if($oldTimestamp->start_time && !$oldTimestamp->end_time){
            $latestRest = $oldTimestamp->rests()->latest()->first();

            if(!$latestRest || $latestRest->end_rest){
                Rest::create([
                    'attendance_id' => $oldTimestamp->id,
                    'start_rest' => Carbon::now(),
                    'end_rest' => null,
                ]);
            }
        }
        return redirect('/');
    }
    
    // 休憩終了処理
    public function endRest(Request $request){
        $user = Auth::user();

        $oldTimestamp = Attendance::where('user_id',$user->id)->latest()->first();
        
        if($oldTimestamp){
            $latestRest = $oldTimestamp->rests()->latest()->first();
            
            if($latestRest && !$latestRest->end_rest){
                $latestRest->update([
                    'end_rest' => Carbon::now(),
                ]);
                return redirect('/');
            }
            return redirect('/');
        }
    }
}