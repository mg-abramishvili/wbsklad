<?php

namespace App\Traits;

use App\Models\RealizationReportDownload;
use App\Traits\downloadRealizationReportItem;
use Carbon\Carbon;

trait addRealizationReportItemsToDownloadQueue
{
    use downloadRealizationReportItem;

    public function addRealizationReportItemsToDownloadQueue($userUID, $key, $startDate, $endDate, $rrdid) {
        $download = new RealizationReportDownload();

        $download->user_uid = $userUID;
        $download->key = $key;
        $download->start_date = $startDate;
        $download->end_date = $endDate;
        $download->rrdid = $rrdid;

        $download->save();
    }
}