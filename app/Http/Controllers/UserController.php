<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPassword;
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
        return view('auth.registration');
    }



    /**
     * login view page
     *
     * @return 
     */
    public function index()
    {
        return view('auth.login');
    }


    /**
     * forgot password view page
     *
     * @return 
     */
    public function forgotPassword()
    {
        return view('auth.forgot-password');
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
            'password' => 'required|min:3',
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


        $user = User::where('email', $request->email)->first();
        if ($user->verified == AppConst::VERIFIED) {
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                return redirect()->intended('dashboard')->with('logged_success', 'You are logged in successfully!');
            } else {
                return redirect()->back()->with('login_error', "Oppes! Incorrect Email or Password.");
            }
        } else {
            return redirect()->back()->with('login_error', "Oppes! Please verify your email account first.");
        }
    }




    /**
     * forgot password post function
     *
     * @return 
     */
    public function postForgotPassword(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|exists:users',
            ],
            [
                'email.exists' => 'Email doesn\'t exists in our database!',
            ]
        );

        $user = User::where('email', $request->email)->first();

        if ($user->verified == AppConst::VERIFIED) {
            $details = [
                'username' => $user->username,
                'token' => $user->token
            ];

            Mail::to($request->email)->send(new ForgotPassword($details));

            return redirect()->back()->with('send_email_success', 'An E-mail send to your inbox to reset password!');
        } else {
            return redirect()->back()->with('send_email_error', 'Please! verify your E-mail account first.');
        }
    }

    /**
     *  show update password form
     *
     * @return 
     */
    public function updatePasswordForm($token)
    {
        $user = User::where('token', $token)->first();


        if ($user) {
            return view('auth.update-password')->with('token',$token);
        } 
        
        return redirect()->route('login')->with('error_invalid_token', "Sorry! Invalid token access.");
        
    }


    /**
     * forgot password post function
     *
     * @return 
     */
    public function postUpdatePassword(Request $request)
    {
        $request->validate(
            [
                'password' => 'required|min:3',
                'cpassword' => 'required|min:3',
            ],
        );

        $password = Hash::make($request->password);

        if($request->password === $request->cpassword){
                User::where('token',$request->token)->update(['password' => $password ]);
            return redirect()->route('login')->with('update_password_success', 'Your password has been updated.');
        }else{
            return redirect()->back()->with('error_password_same', 'Both password\'s are not matching...');

        }


    }



























    /**
     * control dashboard panel
     *
     * @return 
     */
    public function dashboard()
    {
        return view('auth.dashboard');
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
