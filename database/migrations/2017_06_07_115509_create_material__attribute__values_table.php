<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialAttributeValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material__attribute__values', function (Blueprint $table) {
            $table->increments('id');
            $table->string('value')->unique();
            $table->unsignedInteger('attribute_id');

            $table->foreign('attribute_id')
                ->references('id')
                ->on('material__attribute__types')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('material__attribute__values');
    }
}
