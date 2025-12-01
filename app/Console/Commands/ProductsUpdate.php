<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\MessageBag;

class ProductsUpdate extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:products-update
                            {id : ID del prodotto da modificare}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Modifica un prodotto esistente';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $id = $this->argument('id');

        /**
         * Verificare che l'ID sia un numero intero
         */
        if (!is_numeric($id)) {
            $this->fail("L'ID del prodotto deve essere un numero intero.");
        }

        /**
         * Seleziono il prodotto dal database
         * @var \App\Models\Product|null $product
         */
        $product = \App\Models\Product::find($id);

        if (is_null($product)) {
            $this->fail("Il prodotto con ID «{$id}» non esiste.");
        }

        $validator = \Illuminate\Support\Facades\Validator::make([
            'name' => $this->ask('Inserisci il nome del prodotto:', $product->name),
            'description' => $this->ask('Inserisci la descrizione del prodotto:', $product->description),
            'price' => $this->ask('Inserisci il prezzo del prodotto:', $product->price),
            'qty' => $this->ask('Inserisci la quantità del prodotto:', $product->qty),
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

        try {
            $product->name = $validator->getValue('name');
            $product->description = $validator->getValue('description');
            $product->price = $validator->getValue('price');
            $product->qty = $validator->getValue('qty');
            $product->save();

            $this->info('Prodotto aggiornato con successo.');
            $this->newLine();

            $this->call('app:products-single', ['id' => $product->id]);

            return Command::SUCCESS;
        } catch (\Throwable $th) {
            $this->fail($th->getMessage());
        }
    }
}
