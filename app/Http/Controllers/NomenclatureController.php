<?php

namespace App\Http\Controllers;

use App\Models\Nomenclature;
use Illuminate\Http\Request;

class NomenclatureController extends Controller
{
    public function index($uid)
    {
        $user = User::where('uid', $uid)->first();

        return Nomenclature::where('user_id', $user->id)->get();
    }
}
