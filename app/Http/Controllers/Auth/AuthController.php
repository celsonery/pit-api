<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Notifications\Auth\RegisterActivate;
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
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        if ($request->validated()) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'activation_token' => Str::random(60),
                //                'activation_token' => random_int(100000, 999999)
            ]);

            $user->notify(new RegisterActivate($user));

            return response()->json(['message' => 'User created successfully!'], 201);
        }

        return response()->json(['message' => 'Invalid credentials!'], 403);
    }

    /**
     * Login exits user.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if ($request->validated()) {
            $credentials = $request->only(['email', 'password']);
            $credentials['active'] = 1;
            $credentials['deleted_at'] = null;

            if (! Auth::attempt($credentials)) {
                return response()->json(['message' => 'Unauthorized!'], 401);
            }

            $token = $request->user()->createToken('access_token')->plainTextToken;

            $token->expires_at = $request->remember_me ? Carbon::now()->addYear() : Carbon::now()->addDay();

            return response()->json($token, 200);
        }

        return response()->json(['message' => 'Invalid credentials'], 403);
    }

    /**
     * Logout user logged.
     */
    public function logout(): JsonResponse
    {
        Auth::user()->tokens()->revoke();

        return response()->json(['message' => 'User logged out'], 201);
    }

    /**
     * Return user data.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    public function user(): JsonResponse
    {
        return response()->json(auth()->user());
    }

    public function activate($token): JsonResponse
    {
        $user = User::where('activation_token', $token)->first();

        if (! $user) {
            return response()->json(['message' => 'This activation token is invalid!'], 404);
        }

        $user->active = true;
        $user->activation_token = '';

        if (! $user->save()) {
            return response()->json(['message' => 'User activate error!'], 401);
        }

        return response()->json(['message' => 'User activate successfully!'], 200);
    }

    /**
     * Redirect the user to the Provider authentication page.
     *
     * @return JsonResponse
     */
    public function redirectToProvider(string $provider)
    {
        $validated = $this->validateProvider($provider);

        if (! $validated) {
            return response()->json(['error' => 'Please login using facebook, github or google'], 422);
        }

        return Socialite::driver($provider)->stateless()->redirect();
    }

    /**
     * Redirect the user to the Provider authentication page.
     */
    public function handleProviderCallback(string $provider): JsonResponse
    {
        $validated = $this->validateProvider($provider);

        if (! $validated) {
            return response()->json(['error' => 'Please login using facebook, github or google'], 422);
        }

        try {
            $user = Socialite::driver($provider)->stateless()->user();
        } catch (ClientException $exception) {
            return response()->json(['error' => 'Invalid credentials provided'], 422);
        }

        $userCreated = User::firstOrCreate([
            'email' => $user->getEmail(),
        ], [
            'email_verified_at' => now(),
            'name' => $user->getName(),
            'status' => true,
        ]);

        $userCreated->providers()->updateOrCreate([
            'provider' => $provider,
            'provider_id' => $user->getId(),
        ], [
            'avatar' => $user->getAvatar(),
        ]);

        $token = $userCreated->createToken('token-name')->plainTextToken;

        return response()->json($userCreated, 200, ['access_token' => $token]);
    }

    protected function validateProvider(string $provider): bool
    {
        return in_array($provider, ['facebook', 'github', 'google']);
    }
}
