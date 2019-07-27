<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_roles', function (Blueprint $table) {
            $table->unsignedInteger('role_id');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->unsignedInteger('admin_id');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
            $table->primary(['role_id', 'admin_id']);
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
        Schema::dropIfExists('admin_roles');
    }
}
