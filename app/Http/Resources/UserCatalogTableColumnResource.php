<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserCatalogTableColumnResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'field' => $this->catalogTableColumn->field,
            'headerName' => $this->catalogTableColumn->headerName,
            'width' => $this->width,
            'order' => $this->order,
            'isActive' => $this->isActive,
        ];
    }
}
