<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSerial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serial', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('serialkey');
            $table->bigInteger('state');
            $table->date('activedate')->nullable();
            $table->string('userkey')->nullable();
            $table->date('date_out')->nullable();
            $table->string('reason');
            $table->bigInteger('user_create');
            $table->bigInteger('day_active');
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
        Schema::dropIfExists('serial');
    }
}
