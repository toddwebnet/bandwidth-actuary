<?php

namespace App\Jobs;

use App\Services\TrafficImportService;

class TrafficImportJob extends BaseJob
{

    private $row;

    public function __construct($args)
    {
        $requiredKeys = ['row'];
        $this->checkKeys($args, $requiredKeys);
        $this->row = $args['row'];
    }

    public function handle()
    {
        app()->make(TrafficImportService::class)
            ->processImportRow($this->row);
    }
}
