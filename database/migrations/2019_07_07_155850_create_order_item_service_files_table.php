<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemServiceFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_item_service_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_item_service_id');
            $table->foreign('order_item_service_id')->references('id')->on('order_item_services')->onDelete('cascade');
            $table->string('front_file');
            $table->string('back_file')->nullable();
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
        Schema::dropIfExists('order_item_service_files');
    }
}
