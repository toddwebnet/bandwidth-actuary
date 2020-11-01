<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Traffic extends Model
{
    public $timestamps = false;
    protected $table = 'traffic';
    protected $fillable = [
        'ip',
        'timestamp',
        'total_sent',
        'icmp_sent',
        'udp_sent',
        'tcp_sent',
        'ftp_sent',
        'http_sent',
        'p2p_sent',
        'total_rec',
        'icmp_rec',
        'udp_rec',
        'tcp_rec',
        'ftp_rec',
        'http_rec',
        'p2p_rec',
    ];

    public static function exists($ip, $timestamp)
    {
        return (
            self::where(['ip' => $ip, 'timestamp' => $timestamp])
                ->get()
                ->count()
            > 0
        );
    }
}
