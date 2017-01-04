<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComponentStorageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('component_storage', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('component');
            $table->unsignedInteger('storage');
            $table->timestamps();

            $table->foreign('component')->references('id')->on('components');
            $table->foreign('storage')->references('id')->on('storage');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('component_storages');
    }
}
