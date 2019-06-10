<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Nota;
use App\Filme;

class NotaController extends Controller
{
    public function avaliar(Request $request)
    {
        $user = User::find($request->user_id);
        $filme = Filme::where('tmdb_id', $request->filme_tmdb_id)->first();

        return response()->json([
            'user' => $user,
            'filme' => $filme
        ], 200);
    }
}
