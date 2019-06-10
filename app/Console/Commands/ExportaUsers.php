<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Exports\UserGostosExport;
use Maatwebsite\Excel\Facades\Excel;
use App\User;


class ExportaUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:export';

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
        $this->info('Exportando');
        Excel::store(new UserGostosExport(User::all()), 'public/exports/users.csv');
        $this->info('Exportação completa.');
    }
}
