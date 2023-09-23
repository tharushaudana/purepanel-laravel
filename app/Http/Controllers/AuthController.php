<?php

namespace App\Http\Controllers;

use App\Http\Requests\auth\LoginRequest;
use App\Http\Requests\auth\RegisterRequest;
use App\Models\Invitation;
use App\Models\PanelAccess;
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
        $student_id = $request->student_id;

        if (is_null($student_id)) return response()->error('Non student registration not implemented yet.');

        $invitation = Invitation::where('student_id', $student_id)->first();

        $user = User::create([
            'student_id' => $student_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'level' => $invitation->level
        ]);

        //### mark as accepted
        $invitation->accepted = 1;
        $invitation->save();

        //### assign to panel
        $panelaccess = PanelAccess::create([
            'panel_id' => $invitation->panel_id,
            'user_id' => $user->id
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
