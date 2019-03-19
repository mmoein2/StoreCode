<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMainCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('main_codes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->integer('serial');
            $table->integer('score')->default(0);
            $table->integer('expiration_day')->default(0);
            $table->bigInteger('customer_date')->default(0);

            $table->bigInteger('prize_id')->unsigned();
            $table->foreign('prize_id')->references('id')->on('prizes');

            //true when used
            $table->boolean('status')->default(false);


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
        Schema::dropIfExists('main_codes');
    }
}
