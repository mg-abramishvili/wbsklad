<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableView extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $casts = [
        'columns' => 'json'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uid');
    }
}
