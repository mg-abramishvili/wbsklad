<?php

namespace App\Traits;

use App\Models\RealizationReportItem;
use App\Traits\createRealizationReport;
use App\Traits\deleteRealizationReportDownload;
use Carbon\Carbon;

trait downloadRealizationReportItem
{
    use createRealizationReport, deleteRealizationReportDownload;

    public function downloadRealizationReportItem($dlID, $userUID, $key, $startDate, $endDate, $rrdid) {
        $url = "https://suppliers-stats.wildberries.ru/api/v1/supplier/reportDetailByPeriod";
        $url .= "?key=" . $key;
        $url .= "&dateFrom=" . $startDate . "&dateTo=" . $endDate;
        $url .= "&limit=1";
        $url .= "&rrdid=" . $rrdid;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Accept: application/json",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl); curl_close($curl);
        
        $reportItems = json_decode($response);

        if(empty($reportItems)) {
            return response('Ошибка получения данных по API', 500);
        }

        $reportIDs = array();
        $rrdIDs = array();

        foreach($reportItems as $item) {
            if(!in_array($item->realizationreport_id, $reportIDs))
            {
                $reportIDs[] = $item->realizationreport_id;
            }

            $rrdIDs[] = $item->rrd_id;

            if(!RealizationReportItem::where('realizationreport_id', $item->realizationreport_id)->where('barcode', $item->barcode)->first())
            {
                $realizationReportItem = new RealizationReportItem();
    
                $realizationReportItem->realizationreport_id = $item->realizationreport_id;
                $realizationReportItem->suppliercontract_code = $item->suppliercontract_code;
                $realizationReportItem->rrd_id = $item->rrd_id;
                $realizationReportItem->gi_id = $item->gi_id;
                $realizationReportItem->subject_name = $item->subject_name;
                $realizationReportItem->nm_id = $item->nm_id;
                $realizationReportItem->brand_name = $item->brand_name;
                $realizationReportItem->sa_name = $item->sa_name;
                $realizationReportItem->ts_name = $item->ts_name;
                $realizationReportItem->barcode = $item->barcode;
                $realizationReportItem->doc_type_name = $item->doc_type_name;
                $realizationReportItem->quantity = $item->quantity;
                $realizationReportItem->retail_price = $item->retail_price;
                $realizationReportItem->retail_amount = $item->retail_amount;
                $realizationReportItem->sale_percent = $item->sale_percent;
                $realizationReportItem->commission_percent = $item->commission_percent;
                $realizationReportItem->office_name = $item->office_name;
                $realizationReportItem->supplier_oper_name = $item->supplier_oper_name;
                $realizationReportItem->order_dt = Carbon::parse($item->order_dt)->toDateString();
                $realizationReportItem->sale_dt = Carbon::parse($item->sale_dt)->toDateString();
                $realizationReportItem->rr_dt = Carbon::parse($item->rr_dt)->toDateString();
                $realizationReportItem->shk_id = $item->shk_id;
                $realizationReportItem->retail_price_withdisc_rub = $item->retail_price_withdisc_rub;
                $realizationReportItem->delivery_amount = $item->delivery_amount;
                $realizationReportItem->return_amount = $item->return_amount;
                $realizationReportItem->delivery_rub = $item->delivery_rub;
                $realizationReportItem->gi_box_type_name = $item->gi_box_type_name;
                $realizationReportItem->product_discount_for_report = $item->product_discount_for_report;
                $realizationReportItem->supplier_promo = $item->supplier_promo;
                $realizationReportItem->rid = $item->rid;
                $realizationReportItem->ppvz_spp_prc = $item->ppvz_spp_prc;
                $realizationReportItem->ppvz_kvw_prc_base = $item->ppvz_kvw_prc_base;
                $realizationReportItem->ppvz_kvw_prc = $item->ppvz_kvw_prc;
                $realizationReportItem->ppvz_sales_commission = $item->ppvz_sales_commission;
                $realizationReportItem->ppvz_for_pay = $item->ppvz_for_pay;
                $realizationReportItem->ppvz_reward = $item->ppvz_reward;
                $realizationReportItem->ppvz_vw = $item->ppvz_vw;
                $realizationReportItem->ppvz_vw_nds = $item->ppvz_vw_nds;
                $realizationReportItem->ppvz_office_id = $item->ppvz_office_id;
                if(isset($item->ppvz_office_name)) {
                    $realizationReportItem->ppvz_office_name = $item->ppvz_office_name;
                }
                $realizationReportItem->ppvz_supplier_id = $item->ppvz_supplier_id;
                $realizationReportItem->ppvz_supplier_name = $item->ppvz_supplier_name;
                $realizationReportItem->ppvz_inn = $item->ppvz_inn;
                $realizationReportItem->declaration_number = $item->declaration_number;
                $realizationReportItem->sticker_id = $item->sticker_id;
    
                $realizationReportItem->save();
            }
        }

        foreach($reportIDs as $reportID)
        {
            $this->createRealizationReport($userUID, $reportID, $startDate, $endDate);
        }

        if(count($rrdIDs) > 0)
        {
            $this->addRealizationReportItemsToDownloadQueue($userUID, $key, $startDate, $endDate, max($rrdIDs));
        }

        $this->deleteRealizationReportDownload($dlID);
    }
}