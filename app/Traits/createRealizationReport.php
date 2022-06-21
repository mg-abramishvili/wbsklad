<?php

namespace App\Traits;

use App\Models\RealizationReport;

trait createRealizationReport
{   
    public function createRealizationReport($userUID, $id, $startDate, $endDate) {
        $report = RealizationReport::find($id);

        if(!$report)
        {
            $realizationReport = new RealizationReport();
    
            $realizationReport->id = $id;
            $realizationReport->user_uid = $userUID;
            $realizationReport->start_date = $startDate;
            $realizationReport->end_date = $endDate;
            
            $realizationReport->save();
        }
    }
}