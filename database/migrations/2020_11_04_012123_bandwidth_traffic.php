<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BandwidthTraffic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bandwidth_traffic', function (Blueprint $table) {
            $table->integer('year');
            $table->integer('month');
            $table->integer('day');
            $table->string('ip');
            $table->decimal('total', 18, 12);
            $table->decimal('change', 18, 12)->nullable();

            $table->primary(['year', 'month', 'day', 'ip']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bandwidth_traffic');
    }
}
