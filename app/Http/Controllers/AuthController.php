<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistroRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function registro(RegistroRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'] ?? null,
            'password' => Hash::make($data['password']),
        ]);
        return response()->json([
            'user' => $user
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $credenciales = $request->only(['username', 'password']);
        if (!$token = JWTAuth::attempt($credenciales)) {
            return response()->json(['message' => 'Credenciales invalidas'], 401);
        }
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            //'expires_in' => (int) JWTAuth::factory()->getTTL() * 60,
            //'expires_in' => (int) config('jwt.ttl', 60) * 60,

        ]);
    }


    /*public function login(LoginRequest $request): JsonResponse
    {
        try {
            $credenciales = $request->only(['username', 'password']);

            if (!$token = JWTAuth::attempt($credenciales)) {
                return response()->json(['message' => 'Credenciales inválidas'], 401);
            }

            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                //'expires_in' => (int) JWTAuth::factory()->getTTL() * 60,
                'expires_in' => (int) config('jwt.ttl', 60) * 60,

            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ], 500);
        }
    }*/
}
