<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stores = Store::factory()
            ->count(1)
            ->create();

        $products = Product::factory()
            ->count(4)
            ->create();

        foreach ($stores as $store)
            $store->products()->saveMany($products);

    }
}
