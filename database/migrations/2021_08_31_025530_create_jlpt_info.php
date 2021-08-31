<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJlptInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mazii')->create('jlpt_info', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->text('title');
            $table->text('shortDes');
            $table->text('descHtml');
            $table->string('image');
            $table->integer('admin_id');
            $table->integer('language_id')->default(17);
            $table->integer('view')->default(0);

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
        Schema::connection('mazii')->dropIfExists('jlpt_info');
    }
}
