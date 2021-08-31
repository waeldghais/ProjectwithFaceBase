<?php
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TestsenrollmentController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
Route::post('addtest',[TestController::class,'store'])->name('addtest');
Route::get('show',[TestController::class,'index'])->name('show');
Route::get('send',[Controller::class,'sendemail']);
Route::get('send-sms-notification', [Controller::class, 'sendSmsNotificaition']);
Route::get('send-testenrollment',[TestsenrollmentController::class,'sendtestNotificationEmail']);

