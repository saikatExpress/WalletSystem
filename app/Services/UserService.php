<?php

namespace App\Services;

use App\Models\Package;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function __construct()
    {
        if(!Auth::check()){
            return redirect()->route('login');
        }
    }

    public function userDashboard()
    {
        return redirect()->route('user.dashboard')  ;
    }
}