<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealizationReport extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function realizationReportItems()
    {
        return $this->hasMany(RealizationReportItem::class, 'realizationreport_id');
    }
}
