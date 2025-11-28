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
    public function handle()
    {
        // TODO Si recupera il prodotto, vedi ProductsSingle

        $stato = $this->choice('Seleziona lo stato del prodotto', ['Attivo', 'Nascosto']);

//        $product->active = ($stato === 'Attivo');
//        $product->save();

//        $this->call('app:products-single', ['id' => $product->id]);

    }

    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'id' => "Qual è l'ID del prodotto da visualizzare?",
        ];
    }
}
