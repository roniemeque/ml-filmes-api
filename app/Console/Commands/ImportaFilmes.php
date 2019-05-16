<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Filme;
use App\Categoria;

class ImportaFilmes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'filmes:importar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Puxa todos os filmes do csv';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //set the path for the csv files
        $path = storage_path("dataset/movies.csv");

        //read the data into an array
        $data = array_map('str_getcsv', file($path));

        //loop over the data
        $quantidadeSemGenero = 0;

        $progresso = 0;
        foreach ($data as $key => $row) {
            if (!$key) {
                continue;
            }

            if ($row[2] == '(no genres listed)') {
                $quantidadeSemGenero++;
            } else {
                //moldando titulo
                $tituloArray = explode('(', $row[1]);

                //pegando o titulo sem ano e observacoes
                $tituloSemAno = trim($tituloArray[0]);

                //pegando o ano
                $ano = trim($tituloArray[count($tituloArray) - 1]);

                //criando filme
                $filme = Filme::create([
                    'id' => intval($row[0]),
                    'titulo_original' => $tituloSemAno,
                    //removendo parenteses restantes do ano
                    'ano' => str_replace(["(", ")"], "", $ano)
                ]);

                //criando e vinculando categorias
                $categoriasArray = explode('|', $row[2]);

                foreach ($categoriasArray as $categoriaNomeOriginal) {
                    $categoria = Categoria::firstOrCreate(['titulo_original' => $categoriaNomeOriginal]);
                    $filme->categorias()->attach($categoria);
                }

                $progressoAtual = ceil($key / count($data) * 100);
                if ($progresso != $progressoAtual) {
                    $progresso = $progressoAtual;
                    $this->info('Progresso: ' . $progresso . '%');
                }
            }
        }

        $this->info('Filmes sem gênero: ' . $quantidadeSemGenero);
    }
}
