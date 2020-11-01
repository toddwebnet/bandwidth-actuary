<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DailySummary extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_summary', function (Blueprint $table) {
            $table->id();
            $table->string('ip');
            $table->integer('year');
            $table->integer('month');
            $table->integer('day');
            $table->bigInteger('sent')->default(0);
            $table->bigInteger('rec')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_summary');
    }
}
