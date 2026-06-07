<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
  public function register(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|string|min:8|confirmed',
      'phone' => 'nullable|string|max:15',
    ]);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 422);
    }

    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'phone' => $request->phone,
      'role' => 'user', // Default Role
    ]);

    event(new Registered($user));

    $token = auth('api')->login($user);

    return $this->respondWithToken($token, 'Registrasi berhasil. Silakan cek email Anda untuk verifikasi.');
  }

  public function login(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'email' => 'required|email',
      'password' => 'required|string',
    ]);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 422);
    }

    $credentials = $request->only('email', 'password');

    if (!$token = auth('api')->attempt($credentials)) {
      return response()->json(['error' => 'Kredensial email atau password salah'], 401);
    }

    // Sync session for Admin (Agar bisa akses Dashboard Blade)
    $user = auth('api')->user();
    if ($user->role === 'admin') {
        auth('web')->login($user);
    }

    return $this->respondWithToken($token, 'Login berhasil');
  }

  public function me()
  {
    return response()->json(auth('api')->user());
  }

  public function logout()
  {
    auth('api')->logout();
    auth('web')->logout();
    return response()->json(['message' => 'Berhasil logout']);
  }

  public function refresh()
  {
    return $this->respondWithToken(auth('api')->refresh(), 'Token berhasil diperbarui');
  }

  public function forgotPassword(Request $request)
  {
    $request->validate(['email' => 'required|email']);
    $status = Password::sendResetLink($request->only('email'));

    return $status === Password::RESET_LINK_SENT
      ? response()->json(['message' => __($status)])
      : response()->json(['email' => __($status)], 400);
  }

  public function resetPassword(Request $request)
  {
    $request->validate([
      'token' => 'required',
      'email' => 'required|email',
      'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'), function ($user, $password) {
      $user->forceFill(['password' => Hash::make($password)])->setRememberToken(\Illuminate\Support\Str::random(60));
      $user->save();
    });

    return $status === Password::PASSWORD_RESET
      ? response()->json(['message' => __($status)])
      : response()->json(['email' => __($status)], 400);
  }

  protected function respondWithToken($token, $message)
  {
    return response()->json([
      'message' => $message,
      'access_token' => $token,
      'token_type' => 'bearer',
      'expires_in' => auth('api')->factory()->getTTL() * 60,
      'user' => auth('api')->user()
    ]);
  }
}