<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilmesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filmes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titulo_original')->nullable();

            //vamos pegar o titulo pt e a thumb do tmdb
            $table->string('titulo_pt')->nullable();
            $table->integer('imdb_id')->unsigned()->nullable();
            $table->integer('tmdb_id')->unsigned()->nullable();

            $table->json('tmdb_info')->nullable();
            $table->dateTime('tmdb_info_datetime')->nullable();

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
        Schema::dropIfExists('filmes');
    }
}
