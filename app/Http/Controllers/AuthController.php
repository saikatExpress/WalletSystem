<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
            return 1;
        } catch (\Exception $e) {
            DB::rollback();
            info($e);
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');

    }
}
