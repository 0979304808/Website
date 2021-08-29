<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodePurchase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('code_purchase', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('method');
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('address');
            $table->string('items');
            $table->bigInteger('price');
            $table->string('price_raw')->nullable();
            $table->string('care_dairy');
            $table->string('code');
            $table->string('status');
            $table->bigInteger('admin_id');
            $table->string('log')->nullable();
            $table->string('device')->nullable();
            $table->string('ip')->nullable();
            $table->string('country')->nullable();
            $table->timestamp('time_success')->nullable();
            $table->string('level')->nullable();
            $table->string('source')->nullable();
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
        Schema::dropIfExists('code_purchase');
    }
}
