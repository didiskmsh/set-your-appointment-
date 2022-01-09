<?php

use App\Http\Controllers\dashController;


use App\Http\Controllers\firstpageController;
use App\Http\Controllers\meetingController;
use App\Http\Middleware\success_message;
use Illuminate\Support\Facades\Route;
use Spatie\GoogleCalendar\Event;

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

    Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function (){});

Route::post('request/req',[meetingController::class,'follow_request'])->name('follow_request');

Route::post('request/cancel',[meetingController::class,'cancel_request'])->name('cancel_request');

Route::post('request/accept',[meetingController::class,'accept_request'])->name('accept_request');

Route::post('request/decline',[meetingController::class,'decline_request'])->name('decline_request');

Route::get('meeting',[meetingController::class,'create'])->name('create_meeting');

Route::post('meeting/store',[meetingController::class, 'store'])->name('store_meeting');

Route::delete('meeting/delete',[meetingController::class,'delete'])->name('delete_meeting');

Route::put('meeting/reconsider',[meetingController::class,'reconsider_meeting'])->name('reconsider_meeting');

Route::get('meeting/accept',[meetingController::class,'accept_meeting'])->name('accept_meeting');

Route::get('home_page/table',[meetingController::class,'meeting_in_home_page_for_table'])->name('meeting_in_home_page_for_table');

Route::get('home_page/calendar',[meetingController::class,'meeting_in_home_page_for_calendar'])->name('meeting_in_home_page_for_calendar');

Route::get('profile',[meetingController::class,'each_user_profile'])->name('each_user_profile');


require __DIR__.'/auth.php';

