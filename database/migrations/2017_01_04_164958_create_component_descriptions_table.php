<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComponentDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('component_descriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('component');
            $table->text('description');
            $table->timestamps();

            $table->foreign('component')->references('id')->on('components');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('component_descriptions');
    }
}
