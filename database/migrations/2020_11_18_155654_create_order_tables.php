<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTables extends Migration
{
    public function up()
    {
        Schema::create('order_tables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained();
            $table->foreignId('table_id')->constrained();
            $table->dateTime('start_at', 0);
            $table->dateTime('end_at', 0)->nullable();
            $table->time('time_at', 0)->nullable();
            $table->integer('amount')->default(0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_tables');
    }
}
