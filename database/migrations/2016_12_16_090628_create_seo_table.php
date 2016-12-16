<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',100);
            $table->string('keywords');
            $table->text('description');
            $table->string('type',20)->nullable()->default('page');
            $table->string('assoic_id',20);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['title', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("seo");
    }
}
