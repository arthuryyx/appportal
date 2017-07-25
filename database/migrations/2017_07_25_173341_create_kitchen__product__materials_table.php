<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKitchenProductMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kitchen__product__materials', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('kitchen_product_id');
            $table->unsignedInteger('product_part_id');
            $table->unsignedInteger('material_item_id');
            $table->unsignedInteger('qty')->nullable();
            $table->timestamps();

            $table->foreign('kitchen_product_id')
                ->references('id')
                ->on('kitchen__products')
                ->onDelete('cascade');

            $table->foreign('product_part_id')
                ->references('id')
                ->on('product__parts')
                ->onDelete('cascade');

            $table->foreign('material_item_id')
                ->references('id')
                ->on('material__items')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kitchen__product__materials');
    }
}
