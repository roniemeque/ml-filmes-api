<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Nota;
use App\Filme;
use App\Exports\UserGostosExport;
use Maatwebsite\Excel\Facades\Excel;
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

    public function rodarModelo(Request $request)
    {
        //exportar csv
        Excel::store(new UserGostosExport(User::take($request->quantidade_users)->orderBy('id', 'desc')->get()), 'public/exports/temp-users.csv');

        //rodar python em cima do modelo
        $process = new Process('python3 /Users/ronieeduardomeque/Code/tcc/modelo/cluster.py');
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return response()->json('ok', 200);
    }
}
