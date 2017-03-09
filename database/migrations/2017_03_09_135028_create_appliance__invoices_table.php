<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplianceInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appliance__invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('receipt_id')->unique();
            $table->string('job_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('address')->nullable();
            $table->integer('state')->unsigned()->default(0);
            $table->integer('type')->unsigned()->default(0);
            $table->integer('created_by')->unsigned();
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
        Schema::dropIfExists('appliance__invoices');
    }
}
