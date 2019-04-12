<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->bigIncrements('id');
            $table->tinyInteger('status')->default(1);
            $table->integer('score')->default(0);
            $table->string('player');
            $table->unsignedBigInteger('idSeries');
            $table->unsignedBigInteger('idDifficulty');
            $table->foreign('idSeries')->references('id')->on('series')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('idDifficulty')->references('id')->on('difficulties')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('games');
    }
}
