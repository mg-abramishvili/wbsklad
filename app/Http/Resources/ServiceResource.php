<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'uid' => $this->uid,
            'name' => $this->name,
            'contractor' => $this->contractor->name,
            'price' => $this->price,
            'date' => $this->date,
        ];
    }
}
