<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplianceDispatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appliance__dispatches', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('invoice_id');
            $table->unsignedInteger('schedule_id')->nullable();
            $table->dateTime('date')->nullable();
            $table->unsignedFloat('fee')->default(0);
            $table->unsignedInteger('created_by');

            $table->integer('state');
            $table->string('comment')->nullable();

            $table->foreign('invoice_id')
                ->references('id')
                ->on('appliance__invoices')
                ->onDelete('cascade');

            $table->foreign('schedule_id')
                ->references('id')
                ->on('appliance__schedules')
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
        Schema::dropIfExists('appliance__dispatches');
    }
}
