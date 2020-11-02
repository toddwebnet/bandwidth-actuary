<?php

namespace App\Services;

use App\Models\DailySummary;
use App\Models\Traffic;

class SummaryBuilderService
{
    public function addToReport($trafficId)
    {
        $traffic = Traffic::find($trafficId);
        if (!$traffic->processed) {
            $this->addToDailySummary($traffic);
            $traffic->processed = true;
            $traffic->save();
        }

    }

    private function addToDailySummary(Traffic $traffic)
    {
        $data = [
            'ip' => $traffic->ip,
            'year' => date("Y", $traffic->timestamp),
            'month' => date("m", $traffic->timestamp),
            'day' => date("d", $traffic->timestamp)
        ];
        $dailySummary = DailySummary::where($data)->first();
        if ($dailySummary === null) {
            $dailySummary = DailySummary::create($data);
        }
        $dailySummary->sent = $dailySummary->sent + $traffic->total_sent;
        $dailySummary->rec = $dailySummary->rec + $traffic->total_rec;
        $dailySummary->rec = $dailySummary->total + $traffic->total_sent + $traffic->total_rec;
        $dailySummary->save();

    }
}
