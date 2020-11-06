<?php

namespace App\Services;

use App\Models\BandwidthTraffic;
use PHPHtmlParser\Dom;

class WebParserService
{
    public function importWeb()
    {

        $year = date('Y', time());
        $month = date('m', time());
        $day = date('d', time());
        $headings = [
            0 => 'ip',
            1 => 'total',
//            2 => 'sent',
//            3 => 'rec',
//            4 => 'ftp',
//            5 => 'http',
//            6 => 'p2p',
//            7 => 'tcp',
//            8 => 'udp',
//            9 => 'icmp',

        ];

        $url = env('MONTHLY_URL');
        $dom = new Dom();

        $dom->loadFromUrl($url);

        /** @var Dom\Node\HtmlNode $a */
        $table = $dom->find('table');
        $rows = explode('<tr', $table);
        for ($x = 2; $x < count($rows); $x++) {
            $row = $rows[$x];
            $items = explode('<td', $row);
            $dataRow = [];
            for ($y = 1; $y < count($items); $y++) {
                $item = $items[$y];
                $item =
                    strtolower(
                        trim(
                            strip_tags(
                                str_replace(['</td>', '<tt>', '</tt>', '</tr>', '</table>', '&nbsp;'],
                                    '',
                                    substr($item, strpos($item, '>') + 1)
                                )
                            )
                        )
                    );

                if (array_key_exists(count($dataRow), $headings)) {
                    $key = $headings[count($dataRow)];

                    $dataRow[$key] = $this->recalc($key, $item);
                }
            }
            $data[] = $dataRow;
        }
        $this->importData(['year' => $year, 'month' => $month, 'day' => $day], $data);
    }

    private function importData($filters, $data)
    {
        $where = $filters;
        $yesterday = $this->getPreviousDayIps($filters);
        BandwidthTraffic::where($where)
            ->delete();
        foreach ($data as $junk) {
            if (array_key_exists($junk['ip'], $yesterday)) {
                $change = $junk['total'] - $yesterday[$junk['ip']];
            } else {
                $change = $junk['total'];
            }
            BandwidthTraffic::create($where + $junk + ['change' => $change]);
        }
    }

    private function getPreviousDayIps($filters)
    {
        $day = BandwidthTraffic::where(['year' => $filters['year'], 'month' => $filters['month']])
            ->where('day', '<', $filters['day'])
            ->max('day');
        $ips = [];
        if ($day !== null) {
            $filters['day'] = $day;
            foreach (BandwidthTraffic::where($filters)->get() as $traffic) {
                $ips[$traffic->ip] = $traffic->total;
            }
        }
        return $ips;
    }

    private function recalc($key, $item)
    {
        if ($key == 'ip') {
            return $item;
        }

        $type = substr($item, strlen($item) - 1);
        if ($type == 'k') {
            $value = str_replace('.0', '',
                (string)round(substr($item, 0, strlen($item) - 1) / 1024 / 1024, 6)
            );
        } elseif ($type == 'm') {
            $value = str_replace('.0', '',
                (string)round(substr($item, 0, strlen($item) - 1)
                    / 1024, 6)
            );
        } elseif ($type == 'g') {
            $value = str_replace('.0', '',
                (string)round(substr($item, 0, strlen($item) - 1)
                    , 6)
            );
        } else {
            $value = round($item / 1024 / 1024 / 1024,);
        }
        return $value;
    }

}
