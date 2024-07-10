<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            $token = [
                'token' => $user->createToken('token-name')->plainTextToken,
                'user_id' => $user->id,
                'name' => $user->name,
            ];
            return response()->json($token, 200);
        }
        return response()->json(['message' => 'Email ou senha errados'], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}
