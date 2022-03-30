<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Mail\UserVerifyEmail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response('Ошибка авторизации', 500);
        }
            
        $user = User::where('email', $request['email'])->firstOrFail();

        if(!$user->email_verified_at) {
            return response('E-mail не подтвержден', 500);
        }
            
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
        $newUser->verify_key = Str::random(22);
        $newUser->password = bcrypt($request->password);
        $newUser->save();

        $newUserSettings = new Setting();
        $newUserSettings->user_id = $newUser->id;
        $newUserSettings->save();

        $user->catalogTableColumns()->sync([1,2,3,4,5,6,7,8,9]);

        $verifyKey = $newUser->verify_key;

        Mail::to($newUser->email)->send(new UserVerifyEmail($verifyKey));
    }

    public function me(Request $request)
    {
        if($request->user()) {
            return $request->user()->load('settings', 'catalogTableColumns');
        }
    }

    public function verify($key)
    {
        $user = User::where('verify_key', $key)->first();

        if($user->email_verified_at) {
            return response('E-mail уже подтвержден', 500);
        }
        
        $user->email_verified_at = Carbon::now();

        $user->save();
    }
}