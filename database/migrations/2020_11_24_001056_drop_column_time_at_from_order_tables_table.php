<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnTimeAtFromOrderTablesTable extends Migration
{
    public function up()
    {
        Schema::table('order_tables', function (Blueprint $table) {
            $table->dropColumn('time_at');
        });
    }

    public function down()
    {
        Schema::table('order_tables', function (Blueprint $table) {
            $table->time('time_at', 0)->nullable();
        });
    }
}
