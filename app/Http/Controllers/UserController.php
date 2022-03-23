<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function update($uid, Request $request)
    {
        $user = User::where('uid', $uid)->first();

        $user->name = $request->name;
        $user->email = $request->email;
        
        $settings = Setting::where('user_id', $user->id)->first();
        $settings->wb_api_key = $request->wb_api_key;
        $settings->save();

        $user->save();
    }
}
