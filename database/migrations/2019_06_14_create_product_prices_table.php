<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_prices', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->ondelete('cascade');

            $table->unsignedBigInteger('paper_id');
            $table->foreign('paper_id')->references('id')->on('papers')->ondelete('cascade');

            $table->string('values');
            $table->unsignedBigInteger('single_price');
            $table->unsignedBigInteger('double_price');
            $table->unsignedBigInteger('coworker_single_price');
            $table->unsignedBigInteger('coworker_double_price');
            $table->unsignedInteger('min');
            $table->unsignedInteger('max')->nullable();
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
        Schema::dropIfExists('product_prices');
    }
}
