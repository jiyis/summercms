<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->integer('num')->nullable(false)->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['name']);
        });


        Schema::create('tags_data', function (Blueprint $table) {
            $table->integer('tag_id')->unsigned();
            $table->integer('data_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->integer('model_id')->unsigned();

            $table->foreign('tag_id')->references('id')->on('tags')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('cms_category')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->primary(['tag_id']);
            $table->index(['data_id', 'category_id', 'model_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tags_data');
        Schema::drop('tags');
    }
}
