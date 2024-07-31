<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\FindPasswordRequest;
use App\Http\Requests\PasswordRequestRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\Auth\PasswordReset;
use App\Models\User;
use App\Notifications\Auth\PasswordResetRequest;
use App\Notifications\Auth\PasswordResetSuccess;
use Carbon\Carbon;
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

        if ($user && $passwordReset) {
            $user->notify(new PasswordResetRequest($passwordReset->token));
        }

        return response()->json(['message' => 'We have e-mailed your password reset link!']);
    }

    public function find($token): JsonResponse
    {
        $passwordReset = PasswordReset::where('token', $token)
            ->first();

        if (!$passwordReset) {
            return response()->json(['message' => 'Invalid token!'], 404);
        }

        if (Carbon::parse($passwordReset->updated_at)
            ->addMinutes(720)
            ->isPast()) {
            $passwordReset->delete();
            return response()->json(['message' => 'Invalid token!'], 404);
        }

        return response()->json([$passwordReset], 200);
    }

    public function reset(ResetPasswordRequest $request): JsonResponse
    {
        $passwordReset = PasswordReset::where('token', $request->token)->first();

        if (!$passwordReset) {
            return response()->json(['message' => 'Invalid token!'], 404);
        }

        $user = User::where('email', $passwordReset->email)->first();

        $user->password = bcrypt($request->password);
        $user->save();

        $passwordReset->delete();

        $user->notify(new PasswordResetSuccess($passwordReset));

        return response()->json(['message' => 'Password reset successfully!'], 200);
    }
}
