<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealizationReportItem extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function realizationReport()
    {
        return $this->belongsTo(RealizationReport::class, 'realizationreport_id');
    }
}
