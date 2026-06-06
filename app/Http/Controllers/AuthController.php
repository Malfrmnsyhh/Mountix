<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('pages.auth.login');
    }

    public function registerForm()
    {
        return view('pages.auth.register');
    }

    public function forgotForm()
    {
        return view('pages.auth.forgot-password');
    }
}
