<?php

namespace App\Console\Commands;

use App\Services\TrafficImportService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ImportCdfs extends Command
{
    protected $signature = 'import:cdfs';

    public function handle()
    {
        Log::info('import:cdfs');
        app()->make(TrafficImportService::class)
            ->importFromPfSense();
    }

}
