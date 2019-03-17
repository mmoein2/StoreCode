<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_codes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->integer('serial');
            $table->integer('score');

            //0>not used  1->shop 2->burned
            $table->smallInteger('status')->default(0);

            $table->bigInteger('customer_id')->unsigned()->nullable();
            $table->foreign('customer_id')->references('id')->on('customers');

            $table->bigInteger('shop_id')->unsigned()->nullable();
            $table->foreign('shop_id')->references('id')->on('shops');

            $table->integer('expiration_day')->default(0);
            $table->bigInteger('shop_date')->default(0);
            $table->bigInteger('customer_date')->default(0);




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
        Schema::dropIfExists('sub_codes');
    }
}
