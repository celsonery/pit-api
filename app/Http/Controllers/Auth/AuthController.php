<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Register a new user.
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        if ($request->validated()) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'activation_token' => Str::random(60)
            ]);

            return response()->json(['message' => 'User created successfully!'], 201);
        }
        return response()->json(['message' => 'Invalid credentials!'], 403);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        if ($request->validated()) {
            if (!Auth::attempt($request->validated()))
                return response()->json(['message' => 'Unauthorized!'], 401);

            $token = $request->user()->createToken('access_token');

            $token->expires_at = $request->remember_me ? Carbon::now()->addYear() : Carbon::now()->addDay();

            return response()->json($token, 200);
        }

        return response()->json(['message' => 'Invalid credentials'], 403);
    }

    public function logout()
    {


    }

    public function me()
    {
        return auth()->user();
    }
}
