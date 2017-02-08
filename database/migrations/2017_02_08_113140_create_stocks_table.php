<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('aid');
//            $table->string('job');
            $table->string('receipt');
            $table->string('init')->nullable();
            $table->string('assign_to')->nullable();
            $table->string('deliver_to')->nullable();
            $table->string('shelf')->nullable();
            $table->integer('state');

            $table->foreign('aid')
                ->references('id')
                ->on('appliances')
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
        Schema::dropIfExists('stocks');
    }
}
