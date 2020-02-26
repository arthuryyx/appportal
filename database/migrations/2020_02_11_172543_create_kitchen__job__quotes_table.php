<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKitchenJobQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kitchen__job__quotes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('quote_no')->unique();
            $table->string('customer')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
//            $table->float('price')->unsigned()->default(0);
            $table->string('comment')->nullable();
            $table->unsignedInteger('created_by');
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
        Schema::dropIfExists('kitchen__job__quotes');
    }
}
