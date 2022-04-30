<?php

namespace App\Traits;

use App\Models\Product;

trait updateProductCostPrice
{   
    public function updateProductCostPrice($id) {
        $product = Product::find($id);

        $cost_price = 0;

        foreach($product->nomenclatures as $nomenclature) {
            $cost_price += $nomenclature->cost_price * $nomenclature->pivot->quantity;
        }

        $product->cost_price = $cost_price;

        $product->save();
    }
}