<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $user = User::where('uid', $request->user)->first();

        return Product::where('user_id', $user->id)->get();
    }

    public function product($id)
    {
        return Product::where('id', $id)->with('nomenclatures')->first();
    }

    public function update($id, Request $request)
    {
        $product = Product::find($id);
        $product->cost_price = $request->cost_price;
        $product->save();

        $nomenclatures = [];
        foreach($request->nomenclatures as $nomenclature) {
            $nomenclatures[$nomenclature['id']] = ['quantity' => $nomenclature['quantity']];
        }
        $product->nomenclatures()->sync($nomenclatures);
    }

    public function wildberriesLoad(Request $request)
    {
        $user = User::where('uid', $request->user)->with('settings')->first();

        $url = "https://suppliers-stats.wildberries.ru/api/v1/supplier/stocks?dateFrom=2022-03-20T21%3A00%3A00.000Z&key=";
        $url .= $user->settings->wb_api_key;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Accept: application/json",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl); curl_close($curl);
        
        $wbProducts = json_decode($response);

        if(empty($wbProducts)) {
            return response('Ошибка получения данных по API', 500);
        }

        foreach($wbProducts as $wbProduct)
        {
            $product = Product::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'barcode' => $wbProduct->barcode,
                ],
                [
                    'nm_id' => $wbProduct->nmId,
                    'supplier_article' => $wbProduct->supplierArticle,
                    'subject' => $wbProduct->subject,
                    'category' => $wbProduct->category,
                    'brand' => $wbProduct->brand,
                    'price' => $wbProduct->Price,
                    'quantity' => $wbProduct->quantity,
                    'tech_size' => $wbProduct->techSize,
                ]
            );
        }

        return response('Загрузка завершена', 200);
    }
}
