<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockBalanceItem extends Model
{
    use HasFactory;

    public function stockBalance()
    {
        return $this->belongsTo(StockBalance::class);
    }
}
