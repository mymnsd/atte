<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator; 
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\Rest;
use App\Models\User;
use Carbon\Carbon;

class AttendanceController extends Controller
{

    public function getAttendance(Request $request){
        $user = Auth::user();

        $date = $request->input('date');

        //  dateの存在があるかチェック、なければ今日の日付を取得
        if(isset($date)){
            // データベースから日付を取得
            $attendances = Attendance::whereDate('date', [$date])->paginate(5);
        }else{
            $date = Carbon::today()->format('Y-m-d');
            $attendances = Attendance::whereDate('date', [$date])->paginate(5);
        };

        foreach($attendances as $attendance){
            // 休憩記録の取得
            $rests = Rest::where('attendance_id', $attendance->id)->get();
            // 休憩時間の合計を秒単位で計算
            $totalRestTime = $rests->reduce(function ($carry, $rest) {
                if ($rest->start_rest && $rest->end_rest) {
                    $carry += Carbon::parse($rest->end_rest)->diffInSeconds(Carbon::parse($rest->start_rest));
                }
                return $carry;
            }, 0);

            // 実働時間
            if ($attendance->start_time && $attendance->end_time) {
                $startTime = new Carbon($attendance->start_time);
                $endTime = new Carbon($attendance->end_time);
                // 同じ日付の場合
                if($endTime->isSameDay($startTime)){
                    $workingHours = $endTime->diffInSeconds($startTime) - $totalRestTime;
                //日付が異なる場合 
                }else{
                    // 出勤日の23:59:59まで取得
                    $midnight = $startTime->copy()->endOfDay();
                    // 退勤日の0:00:00から退勤時間まで取得
                    $nextDayStart = $endTime->copy()->startOfDay();
                    // 実働時間の計算
                    $workingHours = $midnight->diffInSeconds($startTime) + $endTime->diffInSeconds($nextDayStart) - $totalRestTime;
                    
                }
            } else {
                // 出退勤時間が存在しない、片方だけ、または両方存在しない場合、実働はnull
                $workingHours = null;
            }
            // フォーマットを変換して追加
            $attendance->rest_time = gmdate('H:i:s', $totalRestTime);
            $attendance->working_hours = $workingHours ? gmdate('H:i:s', $workingHours) : '';
            
        }

        $formatteDate = Carbon::parse($date)->format('Y-m-d');

        $prevDate = Carbon::parse($date)->subDay()->format('Y-m-d');
        $nextDate = Carbon::parse($date)->addDay()->format('Y-m-d');

        return view('attendance',compact('attendances','formatteDate','prevDate','nextDate','date'))->withInput($request->all());
    }

    // 勤務開始処理
    public function startAttendance(Request $request){
        $user = Auth::user();
        $today = Carbon::today();

        // 出勤を押した後に再度押せない処理
        // 最後の出勤記録を取得
        $oldTimestamp = Attendance::where('user_id',$user->id)->latest()->first();
        // 変数の初期化、if条件が満たされた場合に日付が設定される
        $oldDay = '';
        // 過去の出勤をチェック
        if($oldTimestamp) {
            $oldStartTime = new Carbon($oldTimestamp->start_time);
            $oldDay = $oldStartTime->startOfDay();
        }

        // $oldDayが今日の日付と異なり、end_timeが空である場合$oldTimestampを更新
        if($oldDay->ne($today) && empty($oldTimestamp->end_time)){
            $oldTimestamp->update([
                'end_time' => Carbon::now()->subSeconds(Carbon::now()->deffInSeconds(Carbon::today())),
                'working_hours' => Carbon::parse($oldTimestamp->start_time)->diffInSeconds(Carbon::now()->subSeconds(Carbon::now()->diffInSeconds(Carbon::today()))) / 3600
            ]);
        }
        // 出勤中である場合リダイレクト
        if($oldTimestamp && $oldDay->eq($today) && (empty($oldTimestamp->end_time))){
            return redirect('/');      
        }
        // 出勤中でない場合新しい勤務記録を作成
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
    
        // 退勤処理がされていない場合のみ退勤処理を実行
        if($outTime){
            if(empty($outTime->end_time)){
                // 休憩中かどうかチェック
                if($outTime->start_rest && !$outTime->end_rest){
                    return redirect('/');
                }else{
                $now = new Carbon();
                $startTime = new Carbon($outTime->start_time);
                }
                
                $outTime->update([
                    'end_time' => $now,
                ]);
                return redirect('/');
            }
            return redirect('/');
        }
    }
}