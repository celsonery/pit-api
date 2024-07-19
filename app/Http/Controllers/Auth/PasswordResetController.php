<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRequestRequest;
use App\Models\Auth\PasswordReset;
use App\Models\User;
use App\Notifications\Auth\PasswordResetRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function create(PasswordRequestRequest $request): JsonResponse
    {
        if (! $request->validated()) {
            return response()->json(['message' => 'Invalid data received!'], 404);
        }

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return response()->json(['message' => 'We cannot find a user with that e-mail address.'], 404);
        }

        $passwordReset = PasswordReset::updateOrCreate(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => Str::random(60),
            ]
        );

        $user->notify(new PasswordResetRequest($passwordReset->token));

        return response()->json(['message' => 'We have e-mailed your password reset link!']);
    }

    public function find(string $token): JsonResponse
    {
        return response()->json(['message' => 'Iniciand dev find: '.$token], 200);
    }

    public function reset(): JsonResponse
    {
        return response()->json(['message' => 'Iniciand dev reset'], 200);
    }
}
