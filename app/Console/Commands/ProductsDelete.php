<?php

namespace App\Console\Commands;

use App\Trait\ImageFunction;
use Illuminate\Console\Command;

class ProductsDelete extends Command
{
    use ImageFunction;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:products-delete
                            {id : ID del prodotto da cancellare}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancella un prodotto';

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

        if ($this->confirm("Sei sicuro di voler cancellare il prodotto?")) {
            try {
                $this->rmImage($product->id);
                $product->delete();

                $this->info('Prodotto cancellato con successo.');
            } catch (\Throwable $th) {
                $this->fail($th->getMessage());
            }
        } else {
            $this->info('Operazione annullata.');
        }

        return Command::SUCCESS;
    }
}
