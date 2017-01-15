<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partial', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',100);
            $table->string('name',100);
            $table->string('group')->nullable();
            $table->text('content');
            $table->integer('order');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['title', 'name', 'group', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('partial');
    }
}
