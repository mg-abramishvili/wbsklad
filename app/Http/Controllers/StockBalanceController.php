<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\StockBalance;
use Illuminate\Http\Request;

class StockBalanceController extends Controller
{
    public function index(Request $request)
    {
        $user = User::where('uid', $request->user)->first();

        return StockBalance::where('user_id', $user->id)->with('nomenclature')->orderBy('date', 'desc')->get();
    }
}
