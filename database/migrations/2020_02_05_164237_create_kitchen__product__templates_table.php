<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKitchenProductTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kitchen__product__templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('model')->unique();
            $table->string('brand')->nullable();
            $table->string('category')->nullable();
            $table->string('description')->nullable();
            $table->string('size');
            $table->integer('status');
            $table->float('lv1')->unsigned()->nullable()->default(null);
            $table->float('lv2')->unsigned()->nullable()->default(null);
            $table->float('lv3')->unsigned()->nullable()->default(null);
            $table->float('lv4')->unsigned()->nullable()->default(null);
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
        Schema::dropIfExists('kitchen__product__templates');
    }
}
