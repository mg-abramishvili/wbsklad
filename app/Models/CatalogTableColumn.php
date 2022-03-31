<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatalogTableColumn extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $casts = [
        'sortable' => 'boolean',
        'resizable' => 'boolean',
    ];

    protected $hidden = [
        'sortable',
        'resizable'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot(['width', 'order']);
    }
}
