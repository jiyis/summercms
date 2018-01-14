<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operation_logs', function(Blueprint $table) {
            $table->increments('id');
            $table->string('controller',50);
            $table->string('action',30);
            $table->string('querystring',255);
            $table->string('method',10);
            $table->integer('userid')->unsigned();
            $table->string('username',100);
            $table->string('ip',20);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['controller', 'action', 'userid', 'username','ip']);
        });

        Schema::create('logs', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('userid')->unsigned();
            $table->string('username', 50);
            $table->string('httpuseragent');
            $table->string('sessionid',100);
            $table->string('ip',20);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['userid', 'username','ip']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('operation_logs');
        Schema::drop('logs');
    }
}
