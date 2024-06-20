<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware('auth')->group(function () {
    // ログインページ
    Route::get('/', [AuthController::class, 'getLogin']);
    Route::post('/',[AuthController::class,'postLogin']);
    // 日付一覧ページ表示
    Route::get('/attendance',[AttendanceController::class,'getAttendance']);
    // 出退勤打刻
    Route::post('/attendance/start',[AttendanceController::class,'startAttendance']);
    Route::post('/attendance/end',[AttendanceController::class,'endAttendance']);
    // 休憩打刻
    Route::post('/break/start',[RestController::class,'startRest']);
    Route::post('break/end',
    [RestController::class,'endRest']);

});