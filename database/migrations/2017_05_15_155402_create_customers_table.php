<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first');
            $table->string('last')->nullable();
            $table->string('phone')->nullable()->unique();
            $table->string('mobile')->nullable()->unique();
            $table->string('email')->nullable()->unique();
            $table->string('comment')->nullable();
            $table->unsignedInteger('type')->default(0);
            $table->timestamps();
        });

        Schema::create('customer_user', function (Blueprint $table) {
            $table->integer('customer_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->primary(['customer_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
        Schema::dropIfExists('customer_user');
    }
}
