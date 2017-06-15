<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material__items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('model');
            $table->unsignedInteger('supplier_id');

            $table->foreign('supplier_id')
                ->references('id')
                ->on('suppliers')
                ->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('material__items__values', function (Blueprint $table) {
            $table->integer('item_id')->unsigned();
            $table->integer('attribute_value_id')->unsigned();

            $table->foreign('item_id')
                ->references('id')
                ->on('material__items')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('attribute_value_id')
                ->references('id')
                ->on('material__attribute__values')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->primary(['item_id', 'attribute_value_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('material__items');
        Schema::dropIfExists('material__items__values');
    }
}
