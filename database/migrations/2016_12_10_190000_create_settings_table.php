<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key')->unique();
            $table->string('display_name');
            $table->text('value');
            $table->text('details');
            $table->string('type');
            $table->integer('order')->default('1');
            $table->softDeletes();
            $table->index(['key', 'display_name', 'type', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cms_settings');
    }
}
