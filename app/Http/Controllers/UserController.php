<?php

namespace App\Http\Controllers;

//use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function update(Request $request): JsonResponse
    {
        $user = User::find($request->user()->id);
        $user->update($request['userData']);

        return response()->json(['message' => 'User updated successfully!'], 200);
    }
}
