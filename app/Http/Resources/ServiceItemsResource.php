<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceItemsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'date' => $this->date,
            'name' => $this->service->name,
            'price' => $this->price,
        ];
    }
}
