<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BandwidthTraffic extends Model
{
    public $timestamps = false;
    protected $table = 'bandwidth_traffic';
    protected $fillable = [
        'year',
        'month',
        "ip",
        "total",
        "sent",
        "rec",
        "ftp",
        "http",
        "p2p",
        "tcp",
        "udp",
        "icmp"
    ];
}
