<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Provider;
use App\Models\User;
use App\Notifications\Auth\RegisterActivate;
use CelsoNery\Initials\Services\Traits\Initials;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    use Initials;

    /**
     * Register a new user.
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            //            'activation_token' => Str::random(60),
            //            'activation_token' => random_int(100000, 999999),
            'role_id' => 4,
            'active' => 1,
        ]);

        //        $user->notify(new RegisterActivate($user));
        $access_token = $user->createToken('access_token')->plainTextToken;

        return response()->json(['user' => $user, 'access_token' => $access_token, 'message' => 'User created successfully!'], 201);
    }

    /**
     * Login exits user.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only(['email', 'password']);
        $credentials['active'] = 1;
        $credentials['deleted_at'] = null;

        if (! Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized!'], 401);
        }

        $userLogged = \auth()->user();

        $userLogged['access_token'] = $request->user()->createToken('access_token')->plainTextToken;

        // $token->expires_at = $request->remember_me ? Carbon::now()->addYear() : Carbon::now()->addDay();

        $avatar = Provider::where('user_id', ($userLogged->id))
            ->select('avatar')
            ->first();

        if (empty($avatar->avatar)) {
            //            $userLogged['avatar'] = initials($userLogged->name);
            $userLogged['avatar'] = $this->getInitials($userLogged->name);
        } else {
            $userLogged['avatar'] = $avatar['avatar'];
        }

        return response()->json(['user' => $userLogged], 200);
    }

    /**
     * Logout user logged.
     */
    public function logout(): JsonResponse
    {
        if (! Auth::user()->currentAccessToken()->delete()) {
            return response()->json(['message' => 'The user token not revoked!']);
        }

        return response()->json(['message' => 'User logged out'], 201);
    }

    /**
     * Return user data.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    public function user(): JsonResponse
    {
        $userLogged = \auth()->user();

        $avatar = Provider::where('user_id', (auth()->user()->id))
            ->select('avatar')
            ->first();

        if (empty($avatar->avatar)) {
            $userLogged['avatar'] = $this->getInitials($userLogged->name);
        } else {
            $userLogged['avatar'] = $avatar['avatar'];
        }

        return response()->json(['user' => $userLogged], 200);
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
}
