<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\Rest;
use App\Models\User;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function getAttendance(Request $request){
        $user = Auth::user();

        $date = $request->input('date',Carbon::today()->toDateString());

        $attendances = Attendance::whereDate('date',$date)->with('user')->get();
        
        foreach($attendances as $attendance){
            $rests = Rest::where('attendance_id', $attendance->id)->get();
            $totalRestTime = $rests->reduce(function ($carry, $rest) {
                if ($rest->start_rest && $rest->end_rest) {
                    $carry += Carbon::parse($rest->end_rest)->diffInSeconds(Carbon::parse($rest->start_rest));
                }
                return $carry;
            }, 0);

            // 実働時間
            if ($attendance->start_time && $attendance->end_time) {
                $workingHours = Carbon::parse($attendance->end_time)->diffInSeconds(Carbon::parse($attendance->start_time)) - $totalRestTime;
            } else {
                $workingHours = null;
            }
            // フォーマットを変換して追加
            $attendance->rest_time = gmdate('H:i:s', $totalRestTime);
            $attendance->working_hours = $workingHours ? gmdate('H:i:s', $workingHours) : 'N/A';
            
            return view('attendance.index', ['attendances' => $attendances]);
        }

        $formatteDate = Carbon::parse($date)->format('Y-m-d');

        return view('attendance',compact('attendances','formatteDate'));
    }
    public function postAttendance(Request $request){
        $user = Auth::user();
    
        $date = $request->input('date',Carbon::today()->toDateString());
        
        $attendances = Attendance::whereDate('date',$date)->with('user')->get();

        foreach($attendances as $attendance){
            // 休憩時間を計算
            $rests = Rest::where('attendance_id', $attendance->id)->get();
            $totalRestTime = $rests->reduce(function ($carry, $rest) {
                if ($rest->start_rest && $rest->end_rest) {
                    $carry += Carbon::parse($rest->end_rest)->diffInSeconds(Carbon::parse($rest->start_rest));
                }
                return $carry;
            }, 0);

            if ($attendance->start_time && $attendance->end_time) {
                $workingHours = Carbon::parse($attendance->end_time)->diffInSeconds(Carbon::parse($attendance->start_time)) - $totalRestTime;
            } else {
                $workingHours = null;
            }

            // フォーマットを変換して追加
            $attendance->rest_time = gmdate('H:i:s', $totalRestTime);
            $attendance->working_hours = $workingHours ? gmdate('H:i:s', $workingHours) : 'N/A';
        }

        $formatteDate = Carbon::parse($date)->format('Y-m-d');

        return view('attendance',compact('attendances','formatteDate'));
    }
    
    // 勤務開始処理
    public function startAttendance(Request $request){
        $user = Auth::user();
        $today = Carbon::today();

        // 最後の出勤記録を取得
        $oldTimestamp = Attendance::where('user_id',$user->id)->latest()->first();

        $oldDay = '';
        // 退勤前に出勤を２回押せない
        if($oldTimestamp) {
            $oldStartTime = new Carbon($oldTimestamp->start_time);
            $oldDay = $oldStartTime->startOfDay();
        }else{
            $today = Attendance::create([
                'user_id' => $user->id,
                'date' => Carbon::today(),
                'start_time' => Carbon::now(),
            ]);
            return redirect('/');
        }
        $today = Carbon::today();

        if(($oldDay == $today) && (empty($oldTimestamp->end_time))){
            return redirect('/');      
        }
        $attendance = Attendance::create([
            'user_id' => $user->id,
            'date' => Carbon::today(),
            'start_time' => Carbon::now(),
            'end_time' => null,
        ]);
        return redirect('/');
    }

    // 勤務終了処理
    public function endAttendance(Request $request){
        $user = Auth::user();
        // 最後の出勤を取得
        $outTime = Attendance::where('user_id',$user->id)->latest()->first();

        $now = new Carbon();
        $startTime = new Carbon($outTime->start_time);
        $startRest = new Carbon($outTime->start_rest);
        $endRest = new Carbon($outTime->end_rest);
        //実労時間(Minute)
        $stayTime = $startTime->diffInMinutes($now);
        $restTime = $startRest-> diffInMinutes($endRest);
        $workingMinute = $stayTime - $restTime;
        //15分刻み
        $workingHour = ceil($workingMinute / 15) * 0.25;

        // 退勤処理がされていない場合のみ退勤処理を実行
        if($outTime){
            if(empty($outTime->end_time)){
                if($outTime->start_rest && !$outTime->end_rest){
                    return redirect('/');
                }else{
                    $outTime->update([
                        'end_time' => Carbon::now(),
                        'working_hours' => $workingHour
                    ]);
                    return redirect('/');
                }
            }else{
                $today = Carbon::today();
                $day = $today->day;
                $oldEndTIme = new Carbon();
                $oldEndTimeDay = $oldEndDay->day;
                if($day == ($oldEndTimeDay)){
                    return redirect('/');
                }else{
                    return redirect('/');
                }
            }
        }else{
            return redirect('/');  
            }
        }
}



