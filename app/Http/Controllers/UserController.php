<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function update(Request $request)
    {
        $user = User::where('uid', $request->user)->first();

        $user->name = $request->name;
        $user->email = $request->email;
        
        $settings = Setting::where('user_uid', $request->user)->first();
        $settings->wb_api_key = $request->wb_api_key;
        $settings->save();

        $user->save();
    }
}
