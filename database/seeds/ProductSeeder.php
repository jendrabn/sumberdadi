<?php

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductRating;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Product::class, 30)->create();
        factory(ProductImage::class, 60)->create();
        factory(ProductRating::class, 90)->create();
    }
}
