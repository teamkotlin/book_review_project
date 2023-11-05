<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return throw ValidationException::withMessages(['email' => 'The provided email is not correct.']);
        }
        if (!Hash::check($request->password, $user->password)) {
            return throw ValidationException::withMessages(['email' => 'The provided email is not correct.']);
        }
        $token = $user->createToken('api-token')->plainTextToken;
        return response()->json(['token' => $token]);

    }
}
