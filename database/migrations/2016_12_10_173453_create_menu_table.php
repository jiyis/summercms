<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->tinyInteger('default');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['default']);
        });

        Schema::create('menu_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('menu_id')->nullable();
            $table->string('title',100);
            $table->string('url',100);
            $table->string('urltype',100);
            $table->string('target')->default('_self');
            $table->integer('parent_id')->nullable()->default(0);
            $table->integer('order');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['title', 'url', 'urltype', 'parent_id', 'order']);
        });

        Schema::table('menu_items', function (Blueprint $table) {
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('menu_items');
        Schema::drop('menus');
    }
}
