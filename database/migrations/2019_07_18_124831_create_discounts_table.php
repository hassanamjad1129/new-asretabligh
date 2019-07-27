<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->boolean('status');
            $table->integer('count_discount')->default(0);
            $table->string('code')->unique();
            $table->enum('type_doing',['percentage','cash']);
            $table->string('value');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->string('maximum_price')->nullable();
            $table->string('minimum_price')->nullable();
            $table->boolean('all_users');
            $table->boolean('all_products');
            $table->integer('usage')->nullable();
            $table->boolean('first_order')->default(0);
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
        Schema::dropIfExists('discounts');
    }
}
