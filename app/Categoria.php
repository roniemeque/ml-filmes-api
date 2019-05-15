<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    public function filmes()
    {
        return $this->belongsToMany('App\Filme');
    }

    public function sumarios()
    {
        return $this->belongsToMany('App\User')
            ->using('App\UserSumario')
            ->withPivot([
                'notas_total',
                'notas_quantidade',
                'created_at',
                'updated_at'
            ]);
    }
}
