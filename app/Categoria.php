<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'titulo_original', 'titulo_pt'];

    public function filmes()
    {
        return $this->belongsToMany('App\Filme');
    }

    public function users()
    {
        return $this->belongsToMany('App\User')
            ->withPivot([
                'notas_total',
                'notas_quantidade',
                'created_at',
                'updated_at'
            ]);
    }
}
