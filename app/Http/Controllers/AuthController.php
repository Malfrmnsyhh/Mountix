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

    public function logout(Request $request)
    {
        // Logout dari guard web dan api
        auth('web')->logout();
        
        try {
            if (auth('api')->check()) {
                auth('api')->logout();
            }
        } catch (\Exception $e) {
            // Token mungkin sudah expired atau invalid
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Berhasil keluar.']);
        }

        return redirect('/login')->with('success', 'Berhasil keluar.');
    }
}
