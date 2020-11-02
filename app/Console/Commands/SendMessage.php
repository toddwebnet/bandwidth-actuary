<?php

namespace App\Console\Commands;

use App\Services\Api\CourierApi;
use Illuminate\Console\Command;

class SendMessage extends Command
{
    protected $signature = 'message:send';

    public function handle()
    {
        dump(
            CourierApi::instance()->sendMessage(env('PHONE_HOME'), 'Eat a Joes')
        );
    }
}
