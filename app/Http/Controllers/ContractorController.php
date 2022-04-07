<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contractor;
use Illuminate\Http\Request;

class ContractorController extends Controller
{
    public function index($uid)
    {
        $user = User::where('uid', $uid)->first();

        return Contractor::where('user_id', $user->id)->get();
    }
}
