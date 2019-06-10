<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function notas()
    {
        return $this->hasMany('App\Nota');
    }

    public function categorias()
    {
        return $this->belongsToMany('App\Categoria')
            ->withPivot([
                'notas_total',
                'notas_quantidade',
                'created_at',
                'updated_at'
            ]);
    }

    public function atualizaMedias()
    {
        foreach ($this->categorias as $categoria) {
            $this->categorias()->updateExistingPivot($categoria->id, [
                'notas_total' => 0,
                'notas_quantidade' => 0
            ]);
        }

        foreach ($this->notas as $nota) {
            if (filled($nota->filme) && filled($nota->filme->categorias)) {
                foreach ($nota->filme->categorias as $categoria) {
                    $userCategoria = $this->categorias()->find($categoria->id);
                    if (filled($userCategoria)) {
                        $userCategoriaPivot = $userCategoria->pivot;
                        $totalAtual = $userCategoriaPivot->notas_total;
                        $contagemAtual = $userCategoriaPivot->notas_quantidade;
                    } else {
                        $totalAtual = 0;
                        $contagemAtual = 0;
                    }

                    $this->categorias()->syncWithoutDetaching([
                        $categoria->id => [
                            'notas_total' => $totalAtual + ceil($nota->valor),
                            'notas_quantidade' => $contagemAtual + 1
                        ]
                    ]);
                }
            }
        }
    }
}
