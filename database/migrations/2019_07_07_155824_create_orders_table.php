<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('transaction_id')->nullable();
            $table->unsignedBigInteger('total_price');
            $table->boolean('payed')->default(0);
            $table->string('address', '1024')->nullable();
            $table->unsignedBigInteger('delivery_method');
            $table->foreign('delivery_method')->references('id')->on('shippings')->onDelete('cascade');
            $table->string('discount')->nullable();
            $table->enum('payment_method', ['money_bag', 'online']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
