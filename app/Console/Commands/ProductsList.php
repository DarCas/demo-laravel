<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class ProductsList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:products-list
                            {--orderBy=name : Ordinamento lista}
                            {--orderDir=asc : Direzione ordinamento}
                            {--page=1 : Pagina da visualizzare}
                            {--perPage=10 : Elementi per pagina}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Visualizza la lista dei prodotti';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $orderBy = $this->option('orderBy');
        $orderDir = $this->option('orderDir');
        $page = $this->option('page');
        $perPage = $this->option('perPage');

        /** @var \Illuminate\Database\Query\Builder $builder */
        $builder = Product::orderBy($orderBy, $orderDir);

        $paginator = $builder->paginate(
            perPage: $perPage,
            page: $page,
        );

        $this->newLine();
        $this->comment(implode(' | ', [
            "Prodotti totali: {$paginator->total()}",
            "Elementi per pagina: {$paginator->perPage()}",
            "Pagina: {$paginator->currentPage()}",
        ]));
        $this->newLine();

        $this->table([
            'ID',
            'Nome',
            'Prezzo',
            'Q.tà',
            'Ultima modifica',
            '👁️',
        ], array_map(function (Product $item) {
            return [
                mb_str_pad($item->id, 5, ' ', STR_PAD_LEFT),
                $item->name,
                mb_str_pad($item->priceVerbose(), 12, ' ', STR_PAD_LEFT),
                mb_str_pad($item->qty, 5, ' ', STR_PAD_LEFT),
                $item->updateAtVerbose(),
                $item->active ? '✅' : '🚫',
            ];
        }, $paginator->items()));

        return Command::SUCCESS;
    }
}
