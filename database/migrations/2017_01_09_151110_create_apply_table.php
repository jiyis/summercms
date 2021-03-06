<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apply_category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',60)->nullable(false);
            $table->string('url',60)->nullable(false)->unique();
            $table->string('layout',100);
            $table->foreign('layout')->references('title')->on('layout')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->text('description');
            $table->text('notice');
            $table->string('deadline',25)->nullable(false);
            $table->string('row')->nullable(false);
            $table->string('column')->nullable(false);
            $table->text('mapping')->nullable(false);
            $table->string('area')->nullable(false)->comment('赛区');
            $table->integer('gid')->nullable(false)->comment('所属游戏分类');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['title', 'gid']);
        });

        Schema::create('apply_user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',60)->nullable(false);
            $table->string('area',30)->nullable(false);
            $table->string('team',60)->nullable(false)->comment('战队名称');
            $table->integer('cid')->unsigned();
            $table->foreign('cid')->references('id')->on('apply_category')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->text('content');
            $table->string('ip',20)->nullable(false);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['name', 'area', 'team', 'ip']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('apply_user');
        Schema::drop('apply_category');
    }
}
