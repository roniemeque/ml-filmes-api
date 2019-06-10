<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Nota;
use App\Filme;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class NotaController extends Controller
{
    public function avaliar(Request $request)
    {
        $filme = Filme::where('tmdb_id', $request->filme_tmdb_id)->first();

        $nota = Nota::updateOrCreate([
            'filme_id' => $filme->id,
            'user_id' => $request->user_id
        ], [
            'valor' => $request->nota
        ]);

        return response()->json([
            'nota' => $nota
        ], 200);
    }

    public function rodarModelo()
    {
        //exportar csv

        //rodar python em cima do modelo

        //retornar sucesso


        $process = new Process('python3 /Users/ronieeduardomeque/Code/tcc/filmes/python/clustering.py');
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return response()->json($process->getOutput(), 200);
    }
}
