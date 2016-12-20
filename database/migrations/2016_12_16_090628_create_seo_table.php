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
            $table->string('seo_title',100);
            $table->string('seo_keyword');
            $table->text('seo_description');
            $table->string('seo_type',20)->nullable()->default('page');
            $table->string('associ_id',20);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['seo_title', 'seo_type']);
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
