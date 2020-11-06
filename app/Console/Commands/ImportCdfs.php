<?php

namespace App\Console\Commands;

use App\Services\Api\CourierApi;
use App\Services\TrafficImportService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ImportCdfs extends Command
{
    protected $signature = 'import:cdfs';

    public function handle()
    {
        Log::info('import:cdfs');
//        CourierApi::instance()->sendMessage(env('PHONE_HOME'), 'CDFS Import started');
        app()->make(TrafficImportService::class)
            ->importFromPfSense();
    }

}
