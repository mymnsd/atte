<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function getAttendance(){
        return view('attendance');
    }
    
    public function startAttendance(Request $request){
        $user = Auth::user();

        $newTimestampDay = Carbon::today();

        $oldTimestamp = Attendance::where('user_id',$user->id)->latest()->first();

        if($oldTimestamp){
            $oldTimestampStartTime = new Carbon($oldTimestamp->start_time);
            $oldTimestampDay = $oldTimestampStartTime->startOfDay();
    
            if(($oldTimestampDay == $newTimestampDay) && (empty($oldTimestamp->end_time))){
                return redirect('/');
            }
        }
        $timestamp = Attendance::create([
            'user_id' => $user->id,
            'date' => $newTimestampDay,
            'start_time' => Carbon::now(),
            'end_time' => null,
        ]);

        return redirect('/');
    }
    public function endAttendance(Request $request){
        $user = Auth::user();

        $timestamp = Attendance::where('user_id',$user->id)->latest()->first();

        if(empty($timestamp->end_time)){
            $timestamp->update([
                // 'date' => $newTimestampDay,
                'end_time' => Carbon::now()
            ]);
            return redirect('/');
        }

        return redirect()->back();
    }
}


