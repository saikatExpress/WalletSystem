<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\TestEmail;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Services\OtpService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Instantiate a new LoginRegisterController instance.
     */
    public function __construct()
    {
        // $this->middleware('guest')->except([
        //     'logout', 'dashboard'
        // ]);
    }


    /**
     * Register Page View
     * Method
     */
    public function register()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                return redirect()->back()->with('message', 'Authentication Successfull');
            }

            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');

        } catch (\Exception $e) {
            DB::rollback();
            info($e);
        }
    }

    public function passwordCreate()
    {
        return view('auth.password');
    }

    public function passwordReset(Request $request)
    {
        try {
            DB::beginTransaction();
            $email = $request->input('email');
            $user = User::whereEmail($email)->first();

            if(!$user){
                return redirect()->back()->with('message', 'This email was wrong');
            }
            
            if($user){
                $otpObj = new OtpService;
                
                $code = $otpObj->sendOtpCode();
                $this->sendOtp($email,$code);
                if($code != null){
                    $r = $otpObj->updateOtpUser($email, $code);
                    DB::commit();

                    return redirect()->route('otp', ['email' => Crypt::encryptString($email), 'code' => Crypt::encryptString($code)]);
                }
            }

        } catch (\Exception $e) {
            DB::rollback();
            info($e);
        }
    }

    public function otpForm($email, $code)
    {
        $email = Crypt::decryptString($email);
        $code = Crypt::decryptString($code);

        $user = User::whereEmail($email)->first();
        $userId = $user->id;

        return view('auth.otp', compact('userId'));
    }

    public function otpStore(Request $request)
    {
        $userId = $request->input('user_id');
        $otp    = $request->input('otp');

        $userExitOtp = Subscription::where('user_id', $userId)->first();

        $existOtp = $userExitOtp->flag;

        if($existOtp != $otp){
            return redirect()->back()->with('message', 'Otp not match!.');
        }
        return redirect()->route('update.password');
    }

    public function editPassword()
    {
        return view('auth.reset_password');
    }

    public function updatePassword(Request $request)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'email'            => ['required', 'email'],
                'password'         => ['required', 'min:6'],
                'confirm-password' => ['required', 'min:6', 'same:password'],
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
            }

            $email = $request->input('email');

            $user = User::where('email', $email)->first();

            if(!$user){
                return redirect()->back()->with('message', 'User Email not found');
            }

            $id = $user->id;

            $updateData = [
                'password' => Hash::make($request->input('password')),
            ];

            $userObj = User::find($id);

            $res = $userObj->update($updateData);
            
            if($res){
                DB::commit();
                Session::flash('success', 'Password changed successfully!');
                return redirect('/');
            }

        } catch (\Exception $e) {
            DB::rollback();
            info($e);
        }
    }

    public function sendOtp($email, $code)
    {   
        $this->sendOtpMail($email, $code);
    }

    protected function sendOtpMail($email, $code)
    {
        $appName = Config::get('app.name');

        $details = [
            'title' => 'Your OTP Code : ' . $code,
            'body' => 'This is  email sent from .' .$appName
        ];

        Mail::to($email)->send(new TestEmail($details));

        return 'Email sent successfully!';
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');

    }
}
