<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\MessageBag;

class ProductsCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:products-create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea un nuovo prodotto';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask('Inserisci il nome del prodotto:');
        $description = $this->ask('Inserisci la descrizione del prodotto:');
        $price = $this->ask('Inserisci il prezzo del prodotto:');
        $qty = $this->ask('Inserisci la quantità del prodotto:');

        $validator = \Illuminate\Support\Facades\Validator::make(
            [
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'qty' => $qty,
            ], [
            'name' => [
                'required',
                'max:150',
            ],
            'description' => 'required|max:65535',
            'price' => [
                'required',
                'decimal:0,2',
                'min:0.01',
                'max:99999999.99',
            ],
            'qty' => [
                'required',
                'integer',
                'min:0',
                'max:65535',
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

        // TODO: Inserire i dati nel database
    }
}
