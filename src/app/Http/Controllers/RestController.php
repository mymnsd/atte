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

        if($oldTimestamp && $oldTimestamp->start_time && !$oldTimestamp->end_time && !$oldTimestamp->start_rest){
            Rest::create([
                'attendance_id' => $oldTimestamp->id,
                'start_rest' => Carbon::now(),
                'end_rest' => null,
            ]);
            return redirect('/');      
        }
        return redirect('/'); 
    }
    
    // 休憩終了処理
    public function endRest(Request $request){
        $user = Auth::user();

        // 最後の出勤を取得
        $oldTimestamp = Attendance::where('user_id',$user->id)->latest()->first();

        // 最後の出勤に関連する休憩を取得
        $restRecord = Rest::where('attendance_id',$oldTimestamp->id)->whereNull('end_rest')->first();

        if($restRecord){
            $restRecord->update([
                'end_rest' => Carbon::now(),
            ]);
            return redirect('/');
        }
        return redirect('/');
    }

}
