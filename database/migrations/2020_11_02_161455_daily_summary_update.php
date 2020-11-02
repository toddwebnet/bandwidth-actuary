<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DailySummaryUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('daily_summary', function($table)
        {
            $table->bigInteger('total')->default(0)->after('day');
        });
        \Illuminate\Support\Facades\DB::update('update daily_summary set total = sent + rec');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
