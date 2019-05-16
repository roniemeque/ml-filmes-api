<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Nota;
use App\User;

class CriaUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notas:criarusers';

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

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Nota::chunk(1000, function ($notas) {
            foreach ($notas as $nota) {
                if (empty($nota->user)) {
                    User::create([
                        'id' => $nota->user_id
                    ]);
                }
            }
        });
    }
}
