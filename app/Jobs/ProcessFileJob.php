<?php

namespace App\Jobs;

use App\Services\TrafficImportService;

class ProcessFileJob extends BaseJob
{

    private $filePath;

    public function __construct($args)
    {
        $requiredKeys = ['filePath'];
        $this->checkKeys($args, $requiredKeys);
        $this->filePath = $args['filePath'];
    }

    public function handle()
    {
        app()->make(TrafficImportService::class)
            ->processFile($this->filePath);
    }
}
