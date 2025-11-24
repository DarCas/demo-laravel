<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Sendmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sendmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Invio e-mail di prova';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // La funzioen $this->ask() permette di chiedere all'utente di inserire un valore
        // $var = $this->ask()

        // Validare tutti i campi

        // Invia e-mail

        return Command::SUCCESS;
    }
}
