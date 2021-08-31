<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

use Twilio\Rest\Client;
class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => ['required', 'numeric', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
         /* Get credentials from .env */
       
        $token = "0171e62fd9ac613822af00121277a921";
        $twilio_sid ="ACa3b0361e73fc795fe7b1a81c4e5e513c";
        $twilio_verify_sid = "VA665c5662caad06c42776045e078b427a";
        $twilio = new Client($twilio_sid, $token);
        $twilio->verify->v2->services($twilio_verify_sid)
            ->verifications
            ->create($request->phone_number, "sms");


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' =>$request->phone_number,
            'password' => Hash::make($request->password),
        ]);
        //event(new Registered($user));
        //Auth::login($user);
      
        return redirect()->route('verify')->with(['phone_number' => $request->phone_number]);
        //return redirect(RouteServiceProvider::HOME);
    }

    protected function verify(Request $request)
    {
        $request->validate([
            'verification_code' => ['required', 'numeric'],
            'phone_number' => ['required', 'string'],
        ]);
        /* Get credentials from .env */
        $token = "0171e62fd9ac613822af00121277a921";
        $twilio_sid ="ACa3b0361e73fc795fe7b1a81c4e5e513c";
        $twilio_verify_sid = "VA665c5662caad06c42776045e078b427a";
        $twilio = new Client($twilio_sid, $token);
        $verification = $twilio->verify->v2->services($twilio_verify_sid)
            ->verificationChecks
            ->create($request->verification_code, array('to' => $request->phone_number));
        if ($verification->valid) {
            $user = tap(User::where('phone_number', $request->phone_number))->update(['isVerified' => true]);
            /* Authenticate user */
        event(new Registered($user));
       // dd(Auth::login($user));
           
             return redirect(RouteServiceProvider::HOME)->with(['message' => 'Phone number verified']);
        }
        return back()->with(['phone_number' => $request->phone_number, 'error' => 'Invalid verification code entered!']);
    }
}
