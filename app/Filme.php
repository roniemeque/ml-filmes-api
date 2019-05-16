<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filme extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'titulo_original', 'categorias_string', 'titulo_pt', 'imdb_id', 'tmdb_id', 'tmdb_info', 'tmdb_info_datetime', 'ano'];

    public function notas()
    {
        return $this->hasMany('App\Nota');
    }

    public function categorias()
    {
        return $this->belongsToMany('App\Categoria');
    }
}
