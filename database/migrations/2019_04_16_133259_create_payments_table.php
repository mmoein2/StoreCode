<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {

            //ResNumber
            $table->bigIncrements('id');
            $table->string('reference_number')->nullable();
            $table->string('trace_number')->nullable();
            $table->string('state')->nullable();
            $table->string('token')->nullable();
            $table->boolean('status')->default(false);
            $table->bigInteger('date');
            $table->bigInteger('amount');

            $table->bigInteger('shop_id')->unsigned()->nullable();
            $table->foreign('shop_id')->references('id')->on('shops');

            $table->boolean('is_used')->default(false);

            $table->bigInteger('post_id')->unsigned();
            $table->foreign('post_id')->references('id')->on('posts');

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
        Schema::dropIfExists('payments');
    }
}
