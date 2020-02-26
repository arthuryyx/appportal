<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->increments('id');
            $table->char('code', 4)->unique();
            $table->string('name')->unique();
            $table->integer('status');
            $table->timestamps();
        });

        Schema::create('region_user', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('region_id')->unsigned();

            $table->foreign('region_id')
                ->references('id')
                ->on('regions');

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->primary(['region_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('region_user');
        Schema::dropIfExists('regions');
    }
}
