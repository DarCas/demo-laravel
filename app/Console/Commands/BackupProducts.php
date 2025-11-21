<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BackupProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:backup-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup della tabella products del database';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $disk = \Storage::disk('local');
        if (!$disk->exists('/products')) {
            $disk->makeDirectory('/products');
        }

        $filename = 'backup-' . date('Ymd-His') . '.json';

        $filepath = $disk->path("/products/{$filename}");

        $products = \App\Models\Product::all();

        file_put_contents($filepath, json_encode($products->toArray()));

        return Command::SUCCESS;
    }
}
