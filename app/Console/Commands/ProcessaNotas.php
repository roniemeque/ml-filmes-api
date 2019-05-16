<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Nota;
use App\User;
use App\UserSumario;

class ProcessaNotas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notas:processar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public $progresso = 0;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        ini_set('memory_limit', '512M');

        $this->progresso = 0;
        User::chunk(100, function ($users) {
            foreach ($users as $key => $user) {

                $this->info('User ' . $user->id);

                $user->load('notas', 'categorias');

                //resetando o sumario atual do user
                if (false) {
                    foreach ($user->categorias as $categoria) {
                        $user->categorias()->updateExistingPivot($categoria->id, [
                            'notas_total' => 0,
                            'notas_quantidade' => 0
                        ]);
                    }
                }

                foreach ($user->notas as $nota) {
                    if (filled($nota->filme) && filled($nota->filme->categorias)) {
                        foreach ($nota->filme->categorias as $categoria) {
                            $userCategoria = $user->categorias()->find($categoria->id);
                            if (filled($userCategoria)) {
                                $userCategoriaPivot = $userCategoria->pivot;
                                $totalAtual = $userCategoriaPivot->notas_total;
                                $contagemAtual = $userCategoriaPivot->notas_quantidade;
                            } else {
                                $totalAtual = 0;
                                $contagemAtual = 0;
                            }

                            $user->categorias()->syncWithoutDetaching([
                                $categoria->id => [
                                    'notas_total' => $totalAtual + ceil($nota->valor),
                                    'notas_quantidade' => $contagemAtual + 1
                                ]
                            ]);
                        }
                    }
                }

                $progressoAtual = ceil($key / 2300 * 100);
                if ($this->progresso != $progressoAtual) {
                    $this->progresso = $progressoAtual;
                    $this->info('Progresso: ' . $this->progresso . '%');
                }
            }
        });
    }
}
