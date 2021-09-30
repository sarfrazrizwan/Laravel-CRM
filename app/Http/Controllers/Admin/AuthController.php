<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuthResource;
use App\Http\Resources\UserResource;
use App\Rules\ValidatePassword;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'bail|required|exists:users',
            'password' => ['required', 'min:8', new ValidatePassword($request->email)],
        ]);

        $user = User::where('email', $request->email)->where('user_type', UserType::SUPER_ADMIN)->first();
        return  new AuthResource($user);
    }
    public function logout()
    {
        $user = auth()->user();
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
        return response()->json(['message' => __('api.LOGOUT')]);

    }
}
