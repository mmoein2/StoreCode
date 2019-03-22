<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfirmShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('confirm_shops', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('shop_id')->unsigned();

            $table->foreign('shop_id')->references('id')->on('shops');

            $table->string('token');
            $table->boolean('is_burned')->default(false);
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
        Schema::dropIfExists('confirm_shops');
    }
}
