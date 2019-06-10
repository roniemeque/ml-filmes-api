<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function cria(Request $request)
    {
        $user = User::firstOrCreate($request->all());

        return response()->json(['user' => $user], 200);
    }

    public function atualizaMedias(User $user)
    {
        $user->atualizaMedias();

        return response()->json([
            'medias' => $user->categorias
        ], 200);
    }

    public function pegaSugestoes(User $user)
    {
        if (!filled($user->grupo)) {
            return response()->json(['filmes' => []], 200);
        }

        $filmesDoUsuario = $user->notas->map(function ($nota) {
            return $nota->filme;
        });

        $filmes = collect([]);

        //pegar vizinhos aleatorios
        $vizinhos = User::inRandomOrder()->take(5)->where('grupo', $user->grupo)->get();

        foreach ($vizinhos as $vizinho) {
            $notas = $vizinho->notas()->orderBy('valor', 'desc')->take(5)->get();
            foreach ($notas as $nota) {
                if (!$filmes->contains(function ($filme) use ($nota) {
                    return $filme->id === $nota->filme_id;
                })) {
                    if (!$filmesDoUsuario->contains(function ($filme) use ($nota) {
                        return $filme->id === $nota->filme_id;
                    })) {
                        $filmes->push($nota->filme);
                    }
                }
            }
        }

        return response()->json(['filmes' => $filmes], 200);
    }
}
