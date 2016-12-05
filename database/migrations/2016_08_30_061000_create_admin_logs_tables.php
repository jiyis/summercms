<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminLogsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_logs', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('userid')->unsigned();
            $table->string('username', 50);
            $table->string('httpuseragent');
            $table->string('sessionid',100);
            $table->string('ip',20);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('admin_logs');
    }
}
