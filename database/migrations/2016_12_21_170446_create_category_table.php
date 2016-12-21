<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create table for storing roles
        Schema::create('cms_category', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->nullable()->default(0);
            $table->string('title',100);
            $table->string('url',100)->unique();
            $table->string('model',50);
            $table->string('template',50);
            $table->string('description');
            $table->integer('order')->nullable()->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['parent_id', 'title', 'model', 'url']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cms_category');
    }
}
