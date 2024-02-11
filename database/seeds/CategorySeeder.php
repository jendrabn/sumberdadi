<?php

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductCategory::insert([
            ['name' => 'Latte'],
            ['name' => 'Cappuccino'],
            ['name' => 'Arabica'],
            ['name' => 'Robusta'],
            ['name' => 'Americano'],
            ['name' => 'Espresso'],
            ['name' => 'Black'],
            ['name' => 'Doppio'],
            ['name' => 'Cortado'],
            ['name' => 'Red Eye'],
            ['name' => 'Mocha'],
            ['name' => 'Ristretto'],
            ['name' => 'Flat White'],
            ['name' => 'Affogato'],
            ['name' => 'Irish'],
        ]);
    }
}
