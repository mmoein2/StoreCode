<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');

            $table->bigInteger('shop_category_id')->unsigned();
            $table->foreign('shop_category_id')->references('id')->on('shop_categories');

            $table->integer('mobile');
            $table->integer('phone');
            $table->text('address');
            $table->string('person');

            $table->bigInteger('score');
            $table->bigInteger('used_score');

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
        Schema::dropIfExists('shops');
    }
}
