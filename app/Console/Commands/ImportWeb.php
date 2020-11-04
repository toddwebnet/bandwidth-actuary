<?php

namespace App\Console\Commands;

use App\Services\ReportNotificationService;
use App\Services\WebParserService;
use Illuminate\Console\Command;

class ImportWeb extends Command
{
    protected $signature = 'import:web';

    public function handle()
    {
        app()->make(WebParserService::class)->importWeb();
        app()->make(ReportNotificationService::class)->notifyUsage();
    }
}
