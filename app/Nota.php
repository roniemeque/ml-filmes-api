<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'filme_id', 'user_id', 'valor'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function filme()
    {
        return $this->belongsTo('App\Filme');
    }
}
