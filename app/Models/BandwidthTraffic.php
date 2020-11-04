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
        'day',
        "ip",
        "total",
        "change",
    ];
}
