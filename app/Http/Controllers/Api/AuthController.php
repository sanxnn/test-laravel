<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'token' => $token,
                'status' => 'success',
            ], 200);
        }

        return response()->json([
            'message' => 'Invalid credentials',
            'status' => 'error',
        ], 401);
    }

    public function logout(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->tokens()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
            'status' => 'success',
        ], 200);
    }

    public function me(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        return response()->json([
            'data' => $user,
            'status' => 'success',
        ], 200);
    }
}
