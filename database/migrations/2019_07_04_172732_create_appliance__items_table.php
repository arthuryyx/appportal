<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplianceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appliance__items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('aid');
            $table->unsignedInteger('invoice_id')->nullable();
            $table->unsignedInteger('quote_id')->nullable();
            $table->unsignedInteger('stock_id')->nullable();
            $table->float('price')->nullable()->unsigned();
            $table->unsignedInteger('warranty')->nullable();
            $table->unsignedInteger('type')->default(0);
            $table->unsignedInteger('state')->default(0);
            $table->timestamps();

            $table->foreign('aid')
                ->references('id')
                ->on('appliances');

            $table->foreign('invoice_id')
                ->references('id')
                ->on('appliance__invoices');

            $table->foreign('quote_id')
                ->references('id')
                ->on('appliance__quotes');

            $table->foreign('stock_id')
                ->references('id')
                ->on('appliance__stocks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appliance__items');
    }
}
