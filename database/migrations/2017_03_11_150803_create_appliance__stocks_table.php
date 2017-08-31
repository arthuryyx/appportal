<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplianceStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appliance__stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('aid');
            $table->unsignedInteger('order_id')->nullable();
            $table->unsignedInteger('arrival_id')->nullable();
            $table->unsignedInteger('assign_to')->nullable();
            $table->unsignedInteger('deliver_to')->nullable();
            $table->unsignedFloat('price')->nullable();
            $table->string('shelf')->nullable();
            $table->integer('state');

            $table->foreign('aid')
                ->references('id')
                ->on('appliances')
                ->onDelete('cascade');

            $table->foreign('order_id')
                ->references('id')
                ->on('appliance__orders')
                ->onDelete('cascade');

             $table->foreign('arrival_id')
                ->references('id')
                ->on('appliance__arrivals')
                ->onDelete('cascade');

            $table->foreign('assign_to')
                ->references('id')
                ->on('appliance__invoices')
                ->onDelete('cascade');

            $table->foreign('deliver_to')
                ->references('id')
                ->on('appliance__deliveries')
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
        Schema::dropIfExists('appliance__stocks');
    }
}
