<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailySummary extends Model
{
    public $timestamps = false;
    protected $table = 'daily_summary';
    protected $fillable = [
        'ip',
        'year',
        'month',
        'day',
        'sent',
        'rec'
    ];

}
