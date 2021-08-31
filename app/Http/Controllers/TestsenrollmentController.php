<?php

namespace App\Http\Controllers;
use App\Notifications\TestEnrollment;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
class TestsenrollmentController extends Controller
{
    public function sendtestNotificationEmail(){
        $user=User::where('email','waeldghaisdg@gmail.com') -> first();
        $enrollmentData =[
            'body'=>'you received a new test notification',
            'enrollmentText'=>'You are allowed to enroll',
            'url'=>url('/'),
            'thankyou'=>'You have 14 day to enroll'
        ];
        //dd($user);
        //1
        //$user->notify(new TestEnrollment($enrollmentData));
        //2
        Notification::send($user,new TestEnrollment($enrollmentData));
    }
}
