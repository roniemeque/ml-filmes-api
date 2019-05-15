<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filme extends Model
{
    public function notas()
    {
        return $this->hasMany('App\Nota');
    }

    public function categorias()
    {
        return $this->belongsToMany('App\Categoria');
    }
}
