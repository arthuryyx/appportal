<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialItemAttributes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material__item__attributes', function (Blueprint $table) {
            $table->integer('mat_tid')->unsigned();
            $table->integer('att_tid')->unsigned();

            $table->foreign('mat_tid')
                ->references('id')
                ->on('material__item__types');
//                ->onUpdate('cascade')
//                ->onDelete('cascade');

            $table->foreign('att_tid')
                ->references('id')
                ->on('material__attribute__types');
//                ->onUpdate('cascade')
//                ->onDelete('cascade');

            $table->primary(['mat_tid', 'att_tid']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('material__item__attributes');
    }
}
