<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_uid',
        'nm_id',
        'supplier_article',
        'subject',
        'barcode',
        'category',
        'brand',
        'price',
        'quantity',
        'uid',
        'tech_size',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uid');
    }

    public function nomenclatures()
    {
        return $this->belongsToMany(Nomenclature::class)->withPivot(['quantity']);
    }
}
