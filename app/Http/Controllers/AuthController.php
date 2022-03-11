<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return 'bad_login';
        }
            
        $user = User::where('email', $request['email'])->firstOrFail();
            
        $token = $user->createToken('auth_token')->plainTextToken;
            
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);

    }

    public function me(Request $request)
    {
        if($request->user()) {
            return $request->user();
        }
    }
}