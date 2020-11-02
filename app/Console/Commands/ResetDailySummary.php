<?php

namespace App\Console\Commands;

use App\Jobs\AddToReportJob;
use App\Models\Traffic;
use App\Services\Api\CourierApi;
use App\Services\QueueService;
use App\Services\SummaryBuilderService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetDailySummary extends Command
{
    protected $signature = 'summary:reset';

    public function handle()
    {
        /** @var SummaryBuilderService $summaryService */
        $summaryBuilderService = app()->make(SummaryBuilderService::class);

        DB::update('delete from daily_summary');
        DB::update('update traffic set processed = 0');
        foreach (Traffic::select('id')->get() as $traffic) {
            QueueService::instance()->sendToQueue(AddToReportJob::class, [
                'id' => $traffic->id
            ], 'compile');
        }

    }
}
