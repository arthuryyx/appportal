<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKitchenProductItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kitchen__product__items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quote_id')->unsigned();
            $table->integer('template_id')->unsigned();
            $table->string('model');
            $table->string('brand');
            $table->string('category');
            $table->float('price')->unsigned();
            $table->string('size')->nullable();
            $table->timestamps();

            $table->foreign('quote_id')
                ->references('id')
                ->on('kitchen__job__quotes');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kitchen__product__items');
    }
}
