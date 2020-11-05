<?php

namespace App\Http\Controllers;

use App\Services\ReportingService;
use Illuminate\Support\Facades\DB;

class ChartController
{
    public function index()
    {
        /** @var ReportingService $reportingService */
        $reportingService = app()->make(ReportingService::class);
        $reportingService->getThisMonthGraph();
        return view('index', $reportingService->getThisMonthGraph());
    }

    public function chart()
    {
        $data = $this->buildData();

        return [
            'type' => 'bar',
            'data' => [
                'labels' => array_keys($data),
                'datasets' => [[
                    'label' => 'Data Usage',
                    'data' => array_values($data),
//                    'backgroundColor' => [
//                        'rgba(255, 99, 132, 0.2)',
//                        'rgba(54, 162, 235, 0.2)',
//                        'rgba(255, 206, 86, 0.2)',
//                        'rgba(75, 192, 192, 0.2)',
//                        'rgba(153, 102, 255, 0.2)',
//                        'rgba(255, 159, 64, 0.2)'
//                    ],
//                    'borderColor' => [
//                        'rgba(255, 99, 132, 1)',
//                        'rgba(54, 162, 235, 1)',
//                        'rgba(255, 206, 86, 1)',
//                        'rgba(75, 192, 192, 1)',
//                        'rgba(153, 102, 255, 1)',
//                        'rgba(255, 159, 64, 1)'
//                    ],
                    'borderWidth' => 1
                ]]
            ],
            'options' => [
                'scales' => [
                    'yAxis' => [
                        [
                            'ticks' => [
                                'beginAtZero' => true
                            ]
                        ]
                    ]

                ],
//                'annotation' => [
//                    'annotations' => $annotations
//                ]
            ]
        ];

    }

    private function buildData()
    {
        $stop = strtotime('2020-10-31');
        $dates = [];
        for ($x = 0; $x < 5; $x++) {
            $time = strtotime("today - {$x} months");
            if ($time < $stop) {
                //     break;
            }
            $where = $this->buildWheres($time);
            $sql = "
            select coalesce(sum(sent+rec),0) as total from daily_summary
            where {$where}
            ";
            $bytes = DB::select($sql)[0]->total;
            $kBytes = $bytes / 1024;
            $mBytes = $kBytes / 1024;
            $gBytes = $mBytes / 1024;
            $dates[date('Y-m', $time)] = $gBytes;
        }
        return $dates;

    }

    private function buildWheres($ts)
    {
        list($year, $month, $day) = explode('.', date("Y.m.d", $ts));
        return " year = {$year}  and month = {$month} ";

    }

    function isa_convert_bytes_to_specified($bytes, $to, $decimal_places = 1)
    {
        $formulas = array(
            'K' => number_format($bytes / 1024, $decimal_places),
            'M' => number_format($bytes / 1048576, $decimal_places),
            'G' => number_format($bytes / 1073741824, $decimal_places)
        );
        return isset($formulas[$to]) ? $formulas[$to] : 0;
    }

}
