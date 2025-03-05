<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register (Request $request) {
        $validator = $request->validate([
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed'
        ]);
        User::query()->create($validator);
        return response()->json(['message' => 'User successfully registered.'], 201);
    }
    public function login (Request $request) {
        $validator = $request->validate([
            'email' => 'required|string|email|max:255|exists:users,email',
            'password' => 'required|string|min:6'
        ]);
        $email = $validator['email'];
        $password = $validator['password'];
        $user = User::query()->where('email', $email)->first();
        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json(['message' => 'The provided credentials are incorrect.'], 401);
        }
        $token = $user->createToken('token')->plainTextToken;
        return response()
            ->json([
                'message' => 'Logged in successfully.',
                'token' => $token,
                'user' => $user,
            ]);
    }
    public function logout (Request $request) {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out.']);
    }
}
