<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppliancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appliances', function (Blueprint $table) {
            $table->increments('id');
            $table->string('model');
            $table->string('barcode')->nullable()->unique();
            $table->integer('brand_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->integer('state');
            $table->float('rrp')->unsigned()->nullable()->default(null);
            $table->float('lv1')->unsigned()->nullable()->default(null);
            $table->float('lv2')->unsigned()->nullable()->default(null);
            $table->float('lv3')->unsigned()->nullable()->default(null);
            $table->float('lv4')->unsigned()->nullable()->default(null);
            $table->string('description')->nullable();
            $table->timestamps();

            $table->foreign('brand_id')
                ->references('id')
                ->on('brands')
                ->onDelete('cascade');

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');

            $table->unique(['model', 'brand_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appliances');
    }
}
