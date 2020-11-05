<?php

namespace App\Services;

use App\Models\BandwidthTraffic;
use App\Models\Host;

class ReportingService
{

    public function getThisMonthGraph()
    {

        $year = date('Y', time());
        $month = date('m', time());
        $day = BandwidthTraffic::where(['year' => $year, 'month' => $month])
            ->max('day');
        $hostNames = Host::pluck('host', 'ip')->toArray();
        $todaysData = BandwidthTraffic::where([
            'year' => $year,
            'month' => $month,
            'day' => $day,
        ])->orderBy('total', 'desc')
            ->get();
        $chunks = BandwidthTraffic::where([
            'year' => $year,
            'month' => $month,
        ])->get();

        $days = BandwidthTraffic::where([
            'year' => $year,
            'month' => $month,
        ])->distinct('day')
            ->orderBy('day', 'desc')
            ->pluck('day');

        $data = [];
        $percent = -1;
        foreach ($todaysData as $today) {
            if ($percent == -1) {
                $percent = round($today->total / 1200 * 100, 2);
            }
            $hostName = (array_key_exists($today->ip, $hostNames)) ? $hostNames[$today->ip] : $today->ip;
            if ($hostNames == 'total') {
                $hostName = 'All Traffic';
            }
            $data[$today->ip] = [
                'hostname' => $hostName,
                'days' => array_fill_keys(
                    $days->toArray(), 0
                )
            ];
        }
        foreach ($chunks as $chunk) {
            if (array_key_exists($chunk->ip, $data)) {
                $data[$chunk->ip]['days'][$chunk->day] = $chunk->total;
            }
        }
        return [
            'percent' => $percent,
            'year' => $year,
            'month' => $month,
            'days' => $days,
            'data' => $data
        ];

    }
}
