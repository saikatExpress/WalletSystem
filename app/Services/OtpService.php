<?php

namespace App\Services;

use App\Models\User;
use App\Models\Subscription;
use App\Mail\TestEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class OtpService
{
    public function sendOtpCode()
    {
        $validDigits = [7, 6, 5, 3]; // Define valid digits
        $code = '';

        for ($i = 0; $i < 4; $i++) {
            $code .= $validDigits[array_rand($validDigits)]; // Append a random valid digit
        }
        return $code;
    }

    public function updateOtpUser($email, $code)
    {
        $subscriptionObj = new Subscription;

        $user = User::where('email', $email)->first();

        $userExist = $subscriptionObj->where('user_id', $user->id)->first();

        if(!$userExist){
            $subscriptionObj->user_id = $user->id;
            $subscriptionObj->flag    = $code;

            $res = $subscriptionObj->save();
        }else{
            $userExist->update(['flag' => $code]);
        }
    }
}