<?php

namespace App\Console\Commands;

use App\Services\TrafficImportService;
use Illuminate\Console\Command;

class ImportCdfs extends Command
{
    protected $signature = 'import:cdfs';

    public function handle()
    {
        app()->make(TrafficImportService::class)
            ->importFromPfSense();
    }

}
