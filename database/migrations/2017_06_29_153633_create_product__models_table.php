<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product__models', function (Blueprint $table) {
            $table->increments('id');

            $table->string('model')->unique();
            $table->unsignedInteger('category_id');

            $table->foreign('category_id')
                ->references('id')
                ->on('product__categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->timestamps();
        });

//        Schema::create('product__materials', function (Blueprint $table) {
//            $table->integer('product_id')->unsigned();
//            $table->integer('material_id')->unsigned();
//
//            $table->foreign('product_id')
//                ->references('id')
//                ->on('product__models')
//                ->onUpdate('cascade')
//                ->onDelete('cascade');
//
//            $table->foreign('material_id')
//                ->references('id')
//                ->on('material__items')
//                ->onUpdate('cascade')
//                ->onDelete('cascade');
//
//            $table->primary(['product_id', 'material_id']);
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product__models');
//        Schema::dropIfExists('product__materials');
    }
}
