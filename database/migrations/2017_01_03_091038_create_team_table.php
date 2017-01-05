<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flag', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('eng_name');
            $table->string('region');
            $table->text('nationinfo')->nullable();
            $table->string('flag');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['name', 'eng_name', 'region']);
        });

        Schema::create('team', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('nationality');
            $table->text('summary')->nullable();
            $table->text('honour')->nullable();
            $table->string('region');
            $table->string('logo');
            $table->integer('gid')->comment('所属游戏id');
            $table->tinyInteger('status')->nullable(false)->default(1)->comment('战队状态');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['name', 'nationality', 'region', 'gid']);
        });

        Schema::create('team_player', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('team_id')->unsigned()->comment('所属战队id');
            $table->foreign('team_id')->references('id')->on('team')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('identification')->nullable();
            $table->string('name');
            $table->string('age')->nullable();
            $table->string('nationality');
            $table->string('summary')->nullable();
            $table->string('setting')->nullable();
            $table->string('userpic')->nullable()->comment('个人头像');
            $table->string('status')->nullable(false)->default(1)->comment('状态');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['identification', 'name', 'nationality']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('flag');
        Schema::drop('team');
        Schema::drop('team_player');
    }
}
