<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StockItemsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'date' => $this->date,
            'quantity' => $this->quantity,
            'price' => $this->price,
        ];
    }
}
