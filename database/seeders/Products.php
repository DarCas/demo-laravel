<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class Products extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 100; ++$i) {
            $product = new Product();
            $product->name = $faker->words(3, true);
            $product->description = $faker->paragraphs(3, true);
            $product->price = $faker->randomFloat(2, 1, 2_000);
            $product->qty = $faker->numberBetween(1, 500);
            $product->save();
        }
    }
}
