<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTempleteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('templete', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',100);
            $table->string('name',50);
            $table->string('model',50);
            $table->string('layout',50);
            $table->string('description');
            $table->text('list');
            $table->text('content');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['title', 'model','name','layout']);
        });

        Schema::create('search_templete', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',100);
            $table->string('name',50);
            $table->string('model',50);
            $table->string('layout',50);
            $table->string('description');
            $table->text('content');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['title', 'model','name','layout']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('templete');
        Schema::drop('search_templete');
    }
}
