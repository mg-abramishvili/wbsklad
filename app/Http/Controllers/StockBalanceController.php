<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\StockBalance;
use App\Models\StockBalanceItem;
use App\Models\Nomenclature;
use App\Models\Product;
use App\Traits\updateMiddlePriceAndQuantity;
use App\Traits\updateProductCostPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StockBalanceController extends Controller
{
    use updateMiddlePriceAndQuantity, updateProductCostPrice;

    public function index(Request $request)
    {
        $user = User::where('uid', $request->user)->first();

        return StockBalance::where('user_id', $user->id)->with('contractor')->withCount('stockBalanceItems')->orderBy('date', 'desc')->get();
    }

    public function stockBalance($uid)
    {
        return StockBalance::where('uid', $uid)->with('nomenclature', 'contractor')->first();
    }

    public function store(Request $request)
    {
        $request->validate([
            'user' => 'required',
            'date' => 'required',
            'contractor_id' => 'required',
            'nomenclatures' => 'required',
        ]);

        $user = User::where('uid', $request->user)->first();

        $stockbalance = new StockBalance();

        $stockbalance->user_id = $user->id;
        
        $stockbalance->uid = Str::random(24);
        $stockbalance->contractor_id = $request->contractor_id;
        $stockbalance->date = $request->date;

        if($request->delivery)
        {
            $stockbalance->delivery_price = $request->delivery['price'];
            $stockbalance->delivery_contractor_id = $request->delivery['contractor'];
        }

        $stockbalance->save();
        
        foreach($request->nomenclatures as $nomenclature) {
            $stockBalanceItem = new StockBalanceItem();
            $stockBalanceItem->nomenclature_id = $nomenclature['id'];
            $stockBalanceItem->stock_balance_id = $stockbalance->id;
            $stockBalanceItem->quantity = $nomenclature['quantity'];
            $stockBalanceItem->price = $nomenclature['total'];
            $stockBalanceItem->date = $request->date;
            $stockBalanceItem->save();
            
            $this->updateMiddlePriceAndQuantity($nomenclature['id']);
        }
    }

    public function update($uid, Request $request)
    {
        $stockbalance = StockBalance::where('uid', $uid)->first();
        
        $stockbalance->contractor_id = $request->contractor_id;
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
}
