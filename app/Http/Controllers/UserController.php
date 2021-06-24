<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Utils\AppConst;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationEmail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;


class UserController extends Controller
{
    /**
     * registration view page
     *
     * @return 
     */
    public function registration()
    {
        if(Auth::check()){
            return Redirect('dashboard');
        }else{
            return view('auth.registration');
        }
        
    }



    /**
     * login view page
     *
     * @return 
     */
    public function index()
    {
        if(Auth::check()){
            return Redirect('dashboard');
        }else{
            return view('auth.login');
        }
    }



    /**
     * user registration post function
     *
     * @return 
     */
    public function postRegistration(Request $request)
    {
        $request->validate([
            'username' => 'required|regex:/^\S*$/u|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();

        $user = $this->create($data);

        $details = [
            'username' => $request->username,
            'token' => $user->token
        ];

        Mail::to($request->email)->send(new VerificationEmail($details));

        return redirect()->route('login')->with('success', 'Account created successfully. A Link has been send to your email to verify your email!');
    }



    /**
     * creating user record in database
     *
     * @return 
     */
    public function create(array $data)
    {
        $token = Str::random(64);

        return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'verified' => AppConst::NO,
            'password' => Hash::make($data['password']),
            'token' => $token
        ]);
    }



    /**
     * verify user email account
     *
     * @return 
     */
    public function verifyAccount($token)
    {
        $user = User::where('token', $token)->first();



        if (!is_null($user)) {
            if (!$user->verified) {

                $user->verified = AppConst::VERIFIED;
                $user->email_verified_at = \Carbon\Carbon::now('utc');
                $user->save();

                return redirect()->route('login')->with('success_email_verify', "Your E-mail is verified. You can now login.");
            } else {
                return redirect()->route('login')->with('already_email_verify', "Your E-mail is already verified. You can now login.");
            }
        } else {
            return redirect()->route('login')->with('error_email_verify', "Sorry! your email cannot be identified.");
        }
    }

    
    /**
     * user login into account
     *
     * @return 
     */
    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);


        // $verifyLogin = User::where('email',$request->email)->where('password',$request->password)->first();
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')->with('logged_success','You are logged in successfully!');
        } else {
            return redirect()->route('login')->with('login_error', "Oppes! Incorrect Email or Password.");
        }
    }

     /**
     * control dashboard panel
     *
     * @return 
     */
    public function dashboard()
    {
        if(Auth::check()){
            return view('auth.dashboard');
        }
  
        return redirect("login")->with('not_allowed_dashboard','Opps! You do not have access');
    }


    /**
     * logout user
     *
     * @return 
     */
    public function logout()
    {
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }
}
