<?php

namespace App\Services;

use App\Models\BandwidthTraffic;
use App\Services\Api\CourierApi;
use Illuminate\Support\Facades\Log;

class ReportNotificationService
{
    public function notifyUsage()
    {
        $gigs = 1224;
        $year = date('Y', time());
        $month = date('m', time());
        $day = date('d', time());
        $maxDay = date('d', strtotime("{$year}-{$month}-01 + 1 month - 1 day"));
        $where = [
            'year' => $year,
            'month' => $month,
            'ip' => 'total'
        ];
        $total = 0;
        try {
            $total = BandwidthTraffic::where($where)->first()->total;
        } catch (\Exception $e) {
            return;
        }
        $total = round($total, 2);
        $percent = round($total / $gigs * 100, 2);
        $relativePercent = round($total / (
                $gigs * ($day / $maxDay)
            ) * 100, 2);

        $text = "Data Usage: {$total}\nTotal Percent: {$percent}%\nRelative Percent: {$relativePercent}%";
        CourierApi::instance()->sendMessage(env('PHONE_HOME'), $text);
        Log::info(json_encode(explode("\n", $text)));

    }
}
