<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nomenclature extends Model
{
    use HasFactory;

    public function stockBalances()
    {
        return $this->hasMany(StockBalance::class);
    }

    public function stockBalanceItems()
    {
        return $this->hasMany(StockBalanceItem::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
