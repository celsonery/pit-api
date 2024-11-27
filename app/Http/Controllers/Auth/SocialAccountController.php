<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAccountController extends Controller
{
    public function redirectToProvider(string $provider)
    {
        $validated = $this->validateProvider($provider);

        if (! $validated) {
            return response()->json(['error' => 'Please login using facebook, github or google'], 422);
        }

        return Socialite::driver($provider)->stateless()->redirect();
    }

    public function handleProviderCallback(string $provider): JsonResponse
    {
        $validated = $this->validateProvider($provider);

        if (! $validated) {
            return response()->json(['error' => 'Please login using facebook, github or google'], 422);
        }

        $user = Socialite::driver($provider)->stateless()->user();

        $userCreated = User::firstOrCreate([
            'email' => $user->getEmail(),
        ], [
            'role_id' => 4,
            'email_verified_at' => now(),
            'name' => $user->getName(),
            'password' => bcrypt(Str::random(16)),
            'status' => true,
            'active' => true,
        ]);

        $userCreated->providers()->updateOrCreate([
            'provider' => $provider,
            'provider_id' => $user->getId(),
        ], [
            'avatar' => $user->getAvatar(),
        ]);

        $userCreated->providers()->where('provider_id', $user->getId())->select('avatar');

        //            = User::with(['providers' => fn ($providers) => $providers->limit(1)->select('avatar', 'user_id')])
        //            ->select(['id', 'name'])
        //            ->find(Auth::user()->id);

        $token = $userCreated->createToken('token-name')->plainTextToken;

        return response()->json(['user' => $userCreated, 'token' => $token], 200);
    }

    protected function validateProvider(string $provider): bool
    {
        return in_array($provider, ['facebook', 'github', 'google']);
    }
}
