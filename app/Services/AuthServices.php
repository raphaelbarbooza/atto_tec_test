<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class AuthServices
{

    // Attempt a login, don't need an instance
    public static function attempt($userMail, $userPassword){
        // Use the default Auth Facades from laravel to auth user
        return Auth::attempt([
            'email' => $userMail,
            'password' => $userPassword
        ]);
    }

}
