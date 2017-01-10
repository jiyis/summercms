<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLayoutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('layout', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',100);
            $table->string('name',50);
            $table->string('description');
            $table->tinyInteger('default')->nullable()->default(0);
            $table->text('content');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['title', 'default']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("layout");
    }
}
