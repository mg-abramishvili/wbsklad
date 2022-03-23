<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response('Ошибка авторизации', 500);
        }
            
        $user = User::where('email', $request['email'])->firstOrFail();
            
        $token = $user->createToken('auth_token')->plainTextToken;
            
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function registration(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if($user) {
            return response('Пользователь с таким E-mail уже зарегистрирован', 500);
        }

        $newUser = new User();
        $newUser->name = $request->name;
        $newUser->email = $request->email;
        $newUser->uid = Str::random(12);
        $newUser->password = bcrypt($request->password);
        $newUser->save();

        $newUserSettings = new Setting();
        $newUserSettings->user_id = $newUser->id;
        $newUserSettings->save();
    }

    public function me(Request $request)
    {
        if($request->user()) {
            return $request->user()->load('settings');
        }
    }
}