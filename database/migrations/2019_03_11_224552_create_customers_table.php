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
            $table->bigIncrements('id');
            $table->integer('mobile');
            $table->bigInteger('score');
            $table->bigInteger('used_score');
            $table->bigInteger('registration_date');

            $table->string('fullname')->nullable();
            $table->string('city')->nullable();
            $table->boolean('IsMan')->nullable();
            $table->integer('national_code')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
