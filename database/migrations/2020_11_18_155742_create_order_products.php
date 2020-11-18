<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProducts extends Migration
{
    public function up()
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->integer('quantity')->default(1);
            $table->integer('amount');
            $table->integer('income')->default(0);
            $table->boolean('return_status')->default(false);
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_products');
    }
}
