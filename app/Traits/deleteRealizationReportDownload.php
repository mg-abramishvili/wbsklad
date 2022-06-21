<?php

namespace App\Traits;

use App\Models\RealizationReportDownload;

trait deleteRealizationReportDownload
{
    public function deleteRealizationReportDownload($id) {
        $download = RealizationReportDownload::find($id);

        $download->delete();
    }
}