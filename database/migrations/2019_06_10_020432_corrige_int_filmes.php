<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CorrigeIntFilmes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('filmes', function (Blueprint $table) {
            $table->bigInteger('tmdb_id')->nullable()->change();
            $table->bigInteger('imdb_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('filmes', function (Blueprint $table) {
            $table->integer('tmdb_id')->nullable()->change();
            $table->integer('imdb_id')->nullable()->change();
        });
    }
}
