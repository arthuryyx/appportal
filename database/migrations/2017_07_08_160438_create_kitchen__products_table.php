<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKitchenProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kitchen__products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('quotation_id');
            $table->unsignedInteger('job_id')->nullable();
            $table->unsignedFloat('price');
            $table->timestamps();

            $table->foreign('quotation_id')
                ->references('id')
                ->on('kitchen__quotations')
                ->onDelete('cascade');

            $table->foreign('product_id')
                ->references('id')
                ->on('product__models')
                ->onDelete('cascade');

            $table->foreign('job_id')
                ->references('id')
                ->on('kitchen__jobs')
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
        Schema::dropIfExists('kitchen__products');
    }
}
