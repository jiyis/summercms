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
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key',100)->unique();
            $table->string('display_name',100);
            $table->text('value');
            $table->text('details');
            $table->string('type',100);
            $table->integer('order')->default('1');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['display_name', 'type', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
