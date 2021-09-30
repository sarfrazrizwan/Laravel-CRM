<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuthResource;
use App\Http\Resources\UserResource;
use App\Rules\ValidatePassword;
use App\User;
use Illuminate\Http\Request;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:users',
            'password' => ['required', 'min:8', new ValidatePassword($request->email)],
        ]);

        $user = User::where('email', $request->email)->first();
        
        return  new AuthResource($user);
    }

    public function logout()
    {
        $user = auth()->user();
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
        return response()->json(['message' => __('api.LOGOUT')]);

    }
    public function sanctumCookies()
    {
        return (new CsrfCookieController())->show();
    }
}
