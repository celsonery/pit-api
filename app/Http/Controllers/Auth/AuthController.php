<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Provider;
use App\Models\User;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

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

    public function logout(): JsonResponse
    {
        Auth::user()->tokens()->delete();

        return response()->json(['message' => 'Logged out'], 201);
    }

    public function me()
    {
        return auth()->user();
    }

    /**
     * Redirect the user to the Provider authentication page.
     *
     * @param string $provider
     * @return JsonResponse
     */
    public function redirectToProvider(string $provider)
    {
        $validated = $this->validateProvider($provider);

        if (!$validated) {
            return response()->json(['error' => 'Please login using facebook, github or google'], 422);
        }

        return Socialite::driver($provider)->stateless()->redirect();
    }

    /**
     * Redirect the user to the Provider authentication page.
     *
     * @param string $provider
     * @return JsonResponse
     */
    public function handleProviderCallback(string $provider): JsonResponse
    {
        $validated = $this->validateProvider($provider);

        if (!$validated) {
            return response()->json(['error' => 'Please login using facebook, github or google'], 422);
        }

        try {
            $user = Socialite::driver($provider)->stateless()->user();
        } catch (ClientException $exception) {
            return response()->json(['error' => 'Invalid credentials provided'], 422);
        }

        $userCreated = User::firstOrCreate([
            'email' => $user->getEmail()
        ], [
            'email_verified_at' => now(),
            'name' => $user->getName(),
            'status' => true,
        ]);

        $userCreated->providers()->updateOrCreate([
            'provider' => $provider,
            'provider_id' => $user->getId(),
        ], [
            'avatar' => $user->getAvatar()
        ]);

        $token = $userCreated->createToken('token-name')->plainTextToken;

        return response()->json($userCreated, 200, ['access_token' => $token]);
    }

    /**
     * @param string $provider
     * @return boolean
     */
    protected function validateProvider(string $provider): bool
    {
        if (in_array($provider, ['facebook', 'github', 'google'])) {
            return true;
        } else {
            return false;
        }
    }
}
