<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Host extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'ip',
        'host',
        'owner'
    ];
}
