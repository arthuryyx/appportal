<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplianceStockRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appliance_stock_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('appliance_order_detail_id')->unsigned();
            $table->integer('deliver_to')->unsigned()->unique()->nullable();
            $table->integer('appliance_id')->unsigned();

            $table->foreign('appliance_order_detail_id')
                ->references('id')
                ->on('appliance_order_details')
                ->onDelete('cascade');

            $table->foreign('deliver_to')
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
        Schema::dropIfExists('appliance__stock__records');
    }
}
