<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Nexmo\Laravel\Facade\Nexmo;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function admin($id)
    {
        $user =User::find($id);
        $user->admin =!$user->admin;
        $user->save();
         return redirect()->back();
    }
     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $user= User::find($id);
        }catch(\Exception $exception){
            dd($exception);
            return view('error.500');
        }
        
        return view('oneuser',compact('user'));
    }
    public function sendemail(){
        $to='macotex2017@gmail.com';
        Mail::send('emails.testemail',['name' => 'wael','email' => 'waeldghaisdg@gmail.com'],function($message) use ($to){
        
            $message->to($to,'Macotext')->subject('Bienvenue notre nouveau enseignant!');
            
        });
    }

    public function sendSmsNotificaition()
    {
      
        Nexmo::message()->send([
            'to' => '21620152636',
            'from' => '21620152636',
            'text' => 'A simple hello message sent from Vonage SMS API'
        ]);
        
 
        dd('SMS message has been delivered.');
        /*$basic  = new \Vonage\Client\Credentials\Basic("1bac3991", "jTvhQTp2quV3Cg0o");
        $client = new \Vonage\Client($basic);
        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS("21620152636", 'Fans bmanar', "te3jebnii !! any why tal3nii za3mee?? sur tt temchich l sahbekk tahkiloo toll     .")
        );
        
        $message = $response->current();
        
        if ($message->getStatus() == 0) {
            echo "The message was sent successfully\n";
        } else {
            echo "The message failed with status: " . $message->getStatus() . "\n";
        }*/
    }
}

