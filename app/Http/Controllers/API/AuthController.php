<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Attempt authentication with 'sdm' guard
        if (Auth::guard('sdm')->attempt($credentials)) {
            $user = Auth::guard('sdm')->user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Hi ' . $user->name . ', selamat datang di sistem payroll',
                'data' => [
                    'user' => $user,
                    'token' => $token,
                    'token_type' => 'Bearer'
                ]
            ]);
        }

        // If authentication fails for both guards, return unauthorized response
        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
