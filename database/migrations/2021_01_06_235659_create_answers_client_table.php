<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswersClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers_clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('answer');
            $table->integer('id_question')->unsigned();
            $table->foreign('id_question')->references('id')->on('question_clients')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('id_client')->unsigned();
            $table->foreign('id_client')->references('id')->on('clients')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('answers_clients');
    }
}
