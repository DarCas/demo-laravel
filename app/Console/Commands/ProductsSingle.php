<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;

class ProductsSingle extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:products-single
                            {id : ID del prodotto da visualizzare}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Visualizza un singolo prodotto';

    /**
     * Execute the console command.
     */
    public function handle(): int
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

        $this->table(['Chiave', 'Valore'], [
            ['ID', $product->id],
            ['Nome', $product->name],
            ['Prezzo', $product->priceVerbose()],
            ['Quantità', $product->qty],
            ['Ultima modifica', $product->updateAtVerbose()],
            ['Visibilità', $product->active ? 'Visibile' : 'Nascosto'],
        ]);

        return Command::SUCCESS;
    }

    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'id' => "Qual è l'ID del prodotto da visualizzare?",
        ];
    }
}
