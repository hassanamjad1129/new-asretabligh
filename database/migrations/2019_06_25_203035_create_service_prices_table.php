<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services')->ondelete('cascade');
            $table->string('values');
            $table->unsignedBigInteger('price')->nullable();
            $table->unsignedBigInteger('single_price')->nullable();
            $table->unsignedBigInteger('double_price')->nullable();
            $table->unsignedBigInteger('coworker_price')->nullable();
            $table->unsignedBigInteger('coworker_single_price')->nullable();
            $table->unsignedBigInteger('coworker_double_price')->nullable();
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
        Schema::dropIfExists('service_prices');
    }
}
