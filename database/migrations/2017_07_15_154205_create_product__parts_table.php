<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product__parts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('product__model_product__part', function (Blueprint $table) {
            $table->integer('model_id')->unsigned();
            $table->integer('part_id')->unsigned();
            $table->unsignedInteger('qty')->nullable();

            $table->foreign('model_id')
                ->references('id')
                ->on('product__models')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('part_id')
                ->references('id')
                ->on('product__parts')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->primary(['model_id', 'part_id']);
        });

        Schema::create('product__part_material__type', function (Blueprint $table) {
            $table->integer('type_id')->unsigned();
            $table->integer('part_id')->unsigned();

            $table->foreign('type_id')
                ->references('id')
                ->on('material__item__types')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('part_id')
                ->references('id')
                ->on('product__parts')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->primary(['type_id', 'part_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product__parts');
        Schema::dropIfExists('product__model_product__part');
        Schema::dropIfExists('product__part_material__type');
    }
}
