<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Nota;
use App\User;

class ImportaNotas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notas:importar';

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

    public function file_get_contents_chunked($file, $chunk_size, $callback)
    {
        try {
            $handle = fopen($file, "r");
            $i = 0;
            while (!feof($handle)) {
                call_user_func_array($callback, array(fread($handle, $chunk_size), &$handle, $i));
                $i++;
            }

            fclose($handle);
        } catch (Exception $e) {
            trigger_error("file_get_contents_chunked::" . $e->getMessage(), E_USER_NOTICE);
            return false;
        }

        return true;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //set the path for the csv files
        $path = storage_path("dataset/ratings.csv");

        $row_count = 0;

        if (($handle = fopen($path, 'r')) !== false) {
            // get the first row, which contains the column-titles (if necessary)
            // $header = fgetcsv($handle);

            // loop through the file line-by-line
            while (($row = fgetcsv($handle)) !== false) {
                //criando nota
                // $nota = new Nota();
                // $nota->fill([
                //     'filme_id' => intval($row[1]),
                //     'valor' => intval(ceil(floatval($row[2])))
                // ]);

                // $user = User::firstOrCreate([
                //     'id' => intval($row[0]),
                // ]);

                // $user->notas()->save($nota);

                $row_count++;
                $this->info($row_count);

                unset($data);
            }
            fclose($handle);
        }

        // $success = $this->file_get_contents_chunked($path, 4096, function ($chunk, &$handle, $iteration) {
        //     /*
        //         * Do what you will with the {&chunk} here
        //         * {$handle} is passed in case you want to seek
        //         ** to different parts of the file
        //         * {$iteration} is the section fo the file that has been read so
        //         * ($i * 4096) is your current offset within the file.
        //     */

        //     if ($iteration < 5) {
        //         $this->info($chunk);
        //     }

        //     //$data = str_getcsv($chunk);

        //     // foreach ($data as $key => $row) {
        //     //     $this->info($row[0]);
        //     // }

        //     // $progresso = 0;
        //     // foreach ($data as $key => $row) {
        //     //     if (!$key) {
        //     //         continue;
        //     //     }

        //     //     //criando nota
        //     //     $nota = new Nota();
        //     //     $nota->fill([
        //     //         'filme_id' => intval($row[1]),
        //     //         'valor' => intval(ceil(floatval($row[2])))
        //     //     ]);

        //     //     $user = User::firstOrCreate([
        //     //         'id' => intval($row[0]),
        //     //     ]);

        //     //     $user->notas()->save($nota);

        //     //     $progressoAtual = ceil($key / count($data) * 100);
        //     //     if ($progresso != $progressoAtual) {
        //     //         $progresso = $progressoAtual;
        //     //         $this->info('Progresso: ' . $progresso . '%');
        //     //     }
        //     // }
        // });

        // if (!$success) {
        //     $this->info('nope');
        // }
    }
}
