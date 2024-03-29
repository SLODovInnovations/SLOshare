<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use RuntimeException;
use Exception;

class DbLoad extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:load';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Naloži prvotno kopijo baze podatkov (uporabno za lokalno testiranje)';

    /**
     * Execute the console command.
     *
     * @throws Exception
     */
    public function handle(): void
    {
        $input = config('database.pristine-db-file');
        $db = config('database.connections.mysql.database');
        $user = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');

        // Necessary to avoid warning about supplying password on CLI.

        putenv(sprintf('MYSQL_PWD=%s', $password));

        $cmd = sprintf(
            'mysql -u %s %s < %s',
            escapeshellarg($user),
            escapeshellarg($db),
            escapeshellarg($input)
        );

        $return = null;

        $output = null;

        exec($cmd, $output, $return);

        throw_if($return !== 0, new RuntimeException(sprintf('Baze podatkov ni bilo mogoče naložiti iz datoteke %s', $input)));
    }
}
