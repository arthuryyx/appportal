<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplianceOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appliance_order_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->integer('initiator')->unsigned()->unique()->nullable();
            $table->integer('assign_to')->unsigned()->unique()->nullable();
            $table->integer('appliance_id')->unsigned();
            $table->integer('state')->unsigned()->default(0);


            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade');

            $table->foreign('initiator')
                ->references('id')
                ->on('project_appliance_records')
                ->onDelete('cascade');

            $table->foreign('assign_to')
                ->references('id')
                ->on('project_appliance_records')
                ->onDelete('cascade');

            $table->foreign('appliance_id')
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
        Schema::dropIfExists('appliance__order__details');
    }
}
