<?php

namespace App\Http\Controllers;

use App\Models\RealizationReport;
use App\Models\RealizationReportItem;
use App\Models\RealizationReportDownload;
use App\Models\User;
use App\Traits\addRealizationReportItemsToDownloadQueue;
use App\Traits\downloadRealizationReportItem;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RealizationReportController extends Controller
{
    use addRealizationReportItemsToDownloadQueue, downloadRealizationReportItem;

    public function index(Request $request)
    {
        $user = User::where('uid', $request->user)->first();

        return RealizationReport::where('user_uid', $user->uid)->orderBy('start_date', 'desc')->get();
    }

    public function report($id)
    {
        return RealizationReport::with('realizationReportItems')->find($id);
    }

    public function import(Request $request)
    {
        $user = User::where('uid', $request->user)->with('settings')->first();

        $startDate = Carbon::now()->startOfWeek()->subWeeks(2)->toDateString();
        $endDate = Carbon::now()->endOfWeek()->subWeeks(2)->toDateString();

        $this->addRealizationReportItemsToDownloadQueue($user->uid, $user->settings->wb_api_key, $startDate, $endDate, 0);
    }

    public function downloader(Request $request)
    {
        $downloads = RealizationReportDownload::all();

        foreach($downloads as $dl)
        {
            $this->downloadRealizationReportItem($dl->id, $dl->user_uid, $dl->key, $dl->start_date, $dl->end_date, $dl->rrdid);
        }
    }
}
