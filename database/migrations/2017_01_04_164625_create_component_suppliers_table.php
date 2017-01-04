<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComponentSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('component_suppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('component');
            $table->unsignedInteger('supplier');
            $table->string('number');
            $table->timestamps();

            $table->foreign('component')->references('id')->on('components');
            $table->foreign('supplier')->references('id')->on('suppliers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('component_suppliers');
    }
}
