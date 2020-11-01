<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Traffic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traffic', function (Blueprint $table) {
            $table->id();
            $table->string('ip');
            $table->bigInteger('timestamp');

            $table->bigInteger('total_sent');
            $table->bigInteger('icmp_sent');
            $table->bigInteger('udp_sent');
            $table->bigInteger('tcp_sent',);
            $table->bigInteger('ftp_sent');
            $table->bigInteger('http_sent');
            $table->bigInteger('p2p_sent');
            $table->bigInteger('total_rec');
            $table->bigInteger('icmp_rec');
            $table->bigInteger('udp_rec');
            $table->bigInteger('tcp_rec');
            $table->bigInteger('ftp_rec');
            $table->bigInteger('http_rec');
            $table->bigInteger('p2p_rec');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('traffic');
    }
}
