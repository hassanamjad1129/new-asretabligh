<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->string('phone', 11);
            $table->string('avatar', 511);
            $table->string('email');
            $table->string('telephone', 11)->nullable();
            $table->enum('type', ['credit', 'cash'])->default('cash');
            $table->enum('gender', ['male', 'female']);
            $table->enum('price', ['coworker', 'normal'])->default('normal');
            $table->bigInteger('credit')->default(0);
            $table->string('password');
            $table->string('password_token')->nullable();
            $table->text('address')->nullable()->default(null);
            $table->rememberToken();
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
        Schema::drop('customers');
    }
}
