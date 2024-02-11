<?php

use App\Models\Store;
use App\Models\StoreBalance;
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
        factory(Store::class, 5)->create();
        factory(StoreBalance::class, 50)->create();
    }
}
