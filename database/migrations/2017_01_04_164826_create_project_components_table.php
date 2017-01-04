<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_components', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('project');
            $table->unsignedInteger('component');
            $table->unsignedInteger('quantity');
            $table->timestamps();

            $table->foreign('project')->references('id')->on('projects');
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
        Schema::dropIfExists('project_components');
    }
}
