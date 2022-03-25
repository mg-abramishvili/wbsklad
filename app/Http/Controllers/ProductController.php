<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index($uid)
    {
        $user = User::where('uid', $uid)->first();

        return Product::where('user_id', $user->id)->get();
    }

    public function wildberriesLoad($uid)
    {
        $user = User::where('uid', $uid)->with('settings')->first();

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

    public function wildberriesLoadList($uid)
    {
        $user = User::where('uid', $uid)->with('settings')->first();

        $url = "https://content-suppliers.wildberries.ru/card/list";

        $headers = array(
            "Accept: application/json",
        );

        $postData = [
            'id' => 1,
            'jsonrpc' => "2.0",
            'supplierID' => "3fa85f64-5717-4562-b3fc-2c963f66afa6",
            'withError' => true
        ];

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($postData));

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl); curl_close($curl);
        
        $wbProducts = json_decode($response);

        return $wbProducts;
    }
}
