<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function setting($user_id)
    {
        return Setting::where('user_id', $user_id)->first();
    }
}
