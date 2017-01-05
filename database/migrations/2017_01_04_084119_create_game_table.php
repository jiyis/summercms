<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //赛事
        Schema::create('match', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description');
            $table->integer('gid');
            $table->tinyInteger('status')->nullable(false)->default(1);
            $table->tinyInteger('default')->nullable(false)->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['title']);
        });
        //赛事小组
        Schema::create('match_group', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('match_id')->unsigned();
            $table->foreign('match_id')->references('id')->on('match')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->tinyInteger('default')->nullable(false)->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['name']);
        });

        //赛事小组的比赛详情
        Schema::create('match_group_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id')->unsigned();
            $table->foreign('group_id')->references('id')->on('match_group')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->integer('team_id_a')->unsigned();
            //$table->foreign('team_id_a')->references('id')->on('team')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('team_id_b')->unsigned();
            //$table->foreign('team_id_b')->references('id')->on('team')->onUpdate('cascade')->onDelete('cascade');
            $table->string('score_a')->nullable(false)->default(0);
            $table->string('score_b')->nullable(false)->default(0);
            $table->string('starttime');
            $table->string('endtime');
            $table->string('link')->nullable();
            $table->tinyInteger('status')->nullable(false)->default(1);
            $table->tinyInteger('default')->nullable(false)->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['team_id_a','team_id_b','score_a', 'score_b', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('match');
        Schema::drop('match_group');
        Schema::drop('match_group_detail');
    }
}
