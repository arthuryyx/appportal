<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplianceOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appliance__orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ref');
            $table->unsignedInteger('invoice_id')->nullable();
            $table->integer('state');
            $table->string('comment')->nullable();
            $table->unsignedInteger('created_by');

            $table->foreign('invoice_id')
                ->references('id')
                ->on('appliance__invoices')
                ->onDelete('cascade');

            $table->timestamps();

            $table->unique(['ref', 'invoice_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appliance__orders');
    }
}
