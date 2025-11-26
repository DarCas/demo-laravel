<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Mail\SentMessage;
use Illuminate\Support\MessageBag;

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
        $nome = $this->ask('Inserisci il tuo nome');
        $cognome = $this->ask('Inserisci il tuo cognome');
        $email = $this->ask('Inserisci il tuo e-mail');
        $telefono = $this->ask('Inserisci il tuo telefono');
        $messaggio = $this->ask('Inserisci il tuo messaggio');

        $validator = \Illuminate\Support\Facades\Validator::make([
            'nome' => $nome,
            'cognome' => $cognome,
            'email' => $email,
            'telefono' => $telefono,
            'messaggio' => $messaggio,
        ], [
            'nome' => [
                'required',
                'max:100',
            ],
            'cognome' => [
                'required',
                'max:100',
            ],
            'email' => [
                'required',
                'email:rfc',
            ],
            'telefono' => [
                'nullable',
            ],
            'messaggio' => [
                'required',
                'max:1000',
            ],
        ]);

        if ($validator->fails()) {
            /** @var MessageBag $errors */
            $errors = $validator->errors();

            foreach ($errors->toArray() as $key => $error) {
                $this->error("{$key}: {$error[0]}");
            }

            return Command::FAILURE;
        }

        $mail = \Illuminate\Support\Facades\Mail::to(
            new \Illuminate\Mail\Mailables\Address(
                address: config('mail.to.address'),
                name: config('mail.to.name'),
            )
        );

        /** @var SentMessage|null $responde */
        $responde = $mail->send(
            new \App\Mail\Contacts([
                'subject' => "Nuovo messaggio da {$validator->getValue('cognome')}, {$validator->getValue('nome')}",
                'nome' => $validator->getValue('nome'),
                'cognome' => $validator->getValue('cognome'),
                'email' => $validator->getValue('email'),
                'telefono' => $validator->getValue('telefono'),
                'messaggio' => $validator->getValue('messaggio'),
            ])
        );

        if (!$responde) {
            $this->error("Errore durante l'invio del messaggio.");

            return Command::FAILURE;
        } else {
            $this->info("Messaggio inviato con successo.");

            return Command::SUCCESS;
        }
    }
}
