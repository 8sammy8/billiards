<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLimitRateIdToOrderTablesTable extends Migration
{
    public function up()
    {
        Schema::table('order_tables', function (Blueprint $table) {
            $table->smallInteger('limit')->default(0);
            $table->foreignId('rate_id')
                ->nullable()
                ->constrained();
        });
    }

    public function down()
    {
        Schema::table('order_tables', function (Blueprint $table) {
            $table->dropColumn('limit');
            $table->dropForeign(['rate_id']);
            $table->dropColumn('rate_id');
        });
    }
}
