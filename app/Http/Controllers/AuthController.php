<?php

namespace App\Http\Controllers;

use App\Http\Requests\auth\LoginRequest;
use App\Http\Requests\auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request) {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->error('Credentials not match!', 401);
        }

        $user = User::where('email', $request->email)->first();

        return response()->success([
            'user' => $user,
            'token' => $this->createNewUserToken($user)
        ]);
    }

    public function register(RegisterRequest $request) {
        $request->validated($request->all());

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->success([
            'user' => $user,
            'token' => $this->createNewUserToken($user)
        ]);
    }

    public function logout() {
        Auth::user()->currentAccessToken()->delete();

        return response()->success(null, 'You have successfully logged out.');
    }

    private function createNewUserToken($user) {
        return $user->createToken('Api Token of '.$user->name)->plainTextToken;
    }
}
