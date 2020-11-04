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
            $table->string('ip');
            $table->decimal('total', 18,12);
            $table->decimal('sent', 18,12);
            $table->decimal('rec', 18,12);
            $table->decimal('ftp', 18,12);
            $table->decimal('http', 18,12);
            $table->decimal('p2p', 18,12);
            $table->decimal('tcp', 18,12);
            $table->decimal('udp', 18,12);
            $table->decimal('icmp', 18,12);
            $table->primary(['year', 'month', 'ip']);
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
