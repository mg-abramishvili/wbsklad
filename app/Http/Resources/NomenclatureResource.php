<?php

namespace App\Http\Resources;

use App\Http\Resources\StockItemsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class NomenclatureResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'uid' => $this->uid,
            'type' => $this->type,
            'artnumber' => $this->artnumber,
            'name' => $this->name,
            'brand' => $this->brand,
            'cost_price' => $this->cost_price,
            'quantity' => $this->quantity,
            'stock_balance_items' => StockItemsResource::collection($this->stockBalanceItems),
        ];
    }
}
