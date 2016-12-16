<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',100);
            $table->string('url',50);
            $table->string('file_name',50);
            $table->text('description');
            $table->text('content');
            $table->string('layout',20);
            $table->tinyInteger('published');
            $table->string('version',20)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['title', 'url']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("page");
    }
}
