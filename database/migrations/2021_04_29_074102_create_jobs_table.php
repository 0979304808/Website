<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mazii')->create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('title');
            $table->text('description');
            $table->text('require');
            $table->text('benifit');
            $table->string('salary');
            $table->string('email');
            $table->string('phone');
            $table->string('country');
            $table->string('province');
            $table->string('address');
            $table->string('majors');
            $table->string('company_info');
            $table->string('website');
            $table->tinyInteger('type');
            $table->tinyInteger('active');
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
        Schema::connection('mazii')->dropIfExists('jobs');
    }
}
