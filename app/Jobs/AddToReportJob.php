<?php

namespace App\Jobs;

use App\Services\SummaryBuilderService;

class AddToReportJob extends BaseJob
{

    private $id;

    public function __construct($args)
    {
        $requiredKeys = ['id'];
        $this->checkKeys($args, $requiredKeys);
        $this->id = $args['id'];
    }

    public function handle()
    {
        app()->make(SummaryBuilderService::class)
            ->addToReport($this->id);
    }
}
