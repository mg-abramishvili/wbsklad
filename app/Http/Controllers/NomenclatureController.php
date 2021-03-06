<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Nomenclature;
use App\Models\Product;
use App\Http\Resources\NomenclatureResource;
use App\Http\Resources\NomenclaturesResource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NomenclatureController extends Controller
{
    public function index(Request $request)
    {
        $user = User::where('uid', $request->user)->first();

        return NomenclaturesResource::collection(Nomenclature::where('user_id', $user->id)->get());
    }

    public function nomenclature($uid)
    {
        return new NomenclatureResource(Nomenclature::where('uid', $uid)->first());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user' => 'required',
            'type' => 'required',
            'artnumber' => 'required',
            'name' => 'required',
            'brand' => 'required',
            'cost_price' => 'required|numeric',
            'quantity' => 'required|numeric',
        ]);

        $user = User::where('uid', $request->user)->first();

        $nomenclature = new Nomenclature();

        $nomenclature->user_id = $user->id;
        $nomenclature->uid = Str::random(24);
        $nomenclature->type = $request->type;
        $nomenclature->artnumber = $request->artnumber;
        $nomenclature->name = $request->name;
        $nomenclature->brand = $request->brand;
        $nomenclature->tech_size = $request->tech_size;
        $nomenclature->cost_price = $request->cost_price;
        $nomenclature->quantity = $request->quantity;

        $nomenclature->save();
    }

    public function update($uid, Request $request)
    {
        $validated = $request->validate([
            'type' => 'required',
            'artnumber' => 'required',
            'name' => 'required',
            'brand' => 'required',
            'cost_price' => 'required|numeric',
            'quantity' => 'required|numeric',
        ]);

        $nomenclature = Nomenclature::where('uid', $uid)->first();

        $nomenclature->type = $request->type;
        $nomenclature->artnumber = $request->artnumber;
        $nomenclature->name = $request->name;
        $nomenclature->brand = $request->brand;
        $nomenclature->tech_size = $request->tech_size;
        $nomenclature->cost_price = $request->cost_price;
        $nomenclature->quantity = $request->quantity;

        $nomenclature->save();
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'user' => 'required',
            'products' => 'required',
        ]);

        $user = User::where('uid', $request->user)->first();

        foreach($request->products as $product) {
            $product = Product::find($product);

            if(!Nomenclature::where('artnumber', $product->supplier_article)->where('tech_size', $product->tech_size)->where('user_id', $user->id)->first()) {
                $nomenclature = new Nomenclature();
    
                $nomenclature->user_id = $user->id;
                $nomenclature->uid = Str::random(24);
                $nomenclature->type = 'tovar';
                $nomenclature->artnumber = $product->supplier_article;
                $nomenclature->name = $product->subject;
                $nomenclature->brand = $product->brand;
                $nomenclature->tech_size = $product->tech_size;
                $nomenclature->cost_price = 0;
                $nomenclature->quantity = 0;
    
                $nomenclature->save();
            }
        }
    }

    public function delete($uid)
    {
        $nomenclature = Nomenclature::where('uid', $uid)->first();

        if(count($nomenclature->serviceItems))
        {
            return response('???????????????????????? ???????????? ?????????????? - ?? ?????? ???????? ?????????????????????? ????????????', 500);
        }

        if(count($nomenclature->stockBalanceItems))
        {
            return response('???????????????????????? ???????????? ?????????????? - ?? ?????? ???????? ??????????????????????', 500);
        }

        if(count($nomenclature->products))
        {
            return response('???????????????????????? ???????????? ?????????????? - ?????? ?????????????? ?? ?????????????? WB', 500);
        }

        $nomenclature->delete();
    }
}
