<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NomenclaturesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uid' => $this->uid,
            'type' => $this->type,
            'artnumber' => $this->artnumber,
            'name' => $this->name,
            'brand' => $this->brand,
            'tech_size' => $this->tech_size,
            'cost_price' => $this->cost_price,
            'quantity' => $this->quantity,
        ];
    }
}
