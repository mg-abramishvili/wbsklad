<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nm_id',
        'supplier_article',
        'subject',
        'barcode',
        'category',
        'brand',
        'price',
        'quantity',
        'tech_size',
    ];

    public function nomenclatures()
    {
        return $this->belongsToMany(Nomenclature::class)->withPivot(['quantity']);
    }
}
