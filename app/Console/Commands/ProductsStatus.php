<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;

class ProductsStatus extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:products-status
                            {id : ID del prodotto da visualizzare}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cambia lo stato di un prodotto';

    /**
     * Execute the console command.
     */
    public function handle(): void
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

        $stato = $this->choice('Seleziona lo stato del prodotto', ['Attivo', 'Nascosto']);

        $product->active = ($stato === 'Attivo');
        $product->save();

        $this->call('app:products-single', ['id' => $product->id]);
    }

    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'id' => "Qual è l'ID del prodotto da visualizzare?",
        ];
    }
}
