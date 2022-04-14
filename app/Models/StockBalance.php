<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockBalance extends Model
{
    use HasFactory;

    public function nomenclature()
    {
        return $this->belongsTo(Nomenclature::class);
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class);
    }
}
