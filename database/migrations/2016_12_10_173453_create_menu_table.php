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
        Schema::create('cms_menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('cms_menu_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('menu_id')->nullable();
            $table->string('title',100);
            $table->string('url',50);
            $table->string('target')->default('_self');
            $table->string('icon')->nullable();
            $table->string('color')->nullable();
            $table->integer('parent_id')->nullable()->default(0);
            $table->integer('order');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['title', 'url', 'parent_id', 'order']);
        });

        Schema::table('cms_menu_items', function (Blueprint $table) {
            $table->foreign('menu_id')->references('id')->on('cms_menus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cms_menu_items');
        Schema::drop('cms_menus');
    }
}
