<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfirmCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('confirm_customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('customer_id')->unsigned();

            $table->foreign('customer_id')->references('id')->on('customers');

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
        Schema::dropIfExists('confirm_customers');
    }
}
