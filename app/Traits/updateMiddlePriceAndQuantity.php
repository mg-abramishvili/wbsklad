<?php

namespace App\Traits;

use App\Models\Nomenclature;
use App\Traits\updateProductCostPrice;

trait updateMiddlePriceAndQuantity
{
    use updateProductCostPrice;
    
    public function updateMiddlePriceAndQuantity($nomenclature_id) {
        $nomenclature = Nomenclature::withSum('stockBalanceItems', 'quantity')->withAvg('stockBalanceItems', 'price')->withAvg('serviceItems', 'price')->find($nomenclature_id);

        $nomenclature->quantity = $nomenclature->stock_balance_items_sum_quantity;
        $nomenclature->cost_price = round($nomenclature->stock_balance_items_avg_price + $nomenclature->service_items_avg_price, 0);

        $nomenclature->save();

        foreach($nomenclature->products as $product) {
            $this->updateProductCostPrice($product->id);
        }
    }
}