<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\StockBalance;
use App\Models\Nomenclature;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StockBalanceController extends Controller
{
    public function index(Request $request)
    {
        $user = User::where('uid', $request->user)->first();

        return StockBalance::where('user_id', $user->id)->with('nomenclature')->orderBy('date', 'desc')->get();
    }

    public function stockBalance($uid)
    {
        return StockBalance::where('uid', $uid)->with('nomenclature')->first();
    }

    public function store(Request $request)
    {
        $user = User::where('uid', $request->user)->first();

        $stockbalance = new StockBalance();

        $stockbalance->user_id = $user->id;
        
        $stockbalance->uid = Str::random(24);
        $stockbalance->nomenclature_id = $request->nomenclature_id;
        $stockbalance->quantity = $request->quantity;
        $stockbalance->price = $request->price;
        $stockbalance->date = $request->date;

        $stockbalance->save();

        $this->updateMiddlePriceAndQuantity($request->nomenclature_id);
    }

    public function update($uid, Request $request)
    {
        $stockbalance = StockBalance::where('uid', $uid)->first();
        
        $stockbalance->quantity = $request->quantity;
        $stockbalance->price = $request->price;
        $stockbalance->date = $request->date;

        $stockbalance->save();

        $this->updateMiddlePriceAndQuantity($stockbalance->nomenclature_id);
    }

    public function delete($uid)
    {
        $stockbalance = StockBalance::where('uid', $uid)->first();

        $stockbalance->delete();

        $this->updateMiddlePriceAndQuantity($stockbalance->nomenclature_id);
    }

    public function updateMiddlePriceAndQuantity($nomenclature_id) {
        $nomenclature = Nomenclature::withSum('stockBalances', 'quantity')->withAvg('stockBalances', 'price')->find($nomenclature_id);
        
        $nomenclature->quantity = $nomenclature->stock_balances_sum_quantity;
        $nomenclature->cost_price = round($nomenclature->stock_balances_avg_price, 0);

        $nomenclature->save();
    }
}
