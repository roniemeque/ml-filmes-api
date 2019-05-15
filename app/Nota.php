<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function filme()
    {
        return $this->belongsTo('App\Filme');
    }
}
