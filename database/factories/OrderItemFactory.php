<?php

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(OrderItem::class, function (Faker $faker) {
    $product = Product::inRandomOrder()->first();
    return [
        'price' => $product->price,
        'product_id' => $product->id,
        'quantity' => $faker->numberBetween(1, 10),
        'order_id' => function () {
            return Order::inRandomOrder()->first()->id;
        },
    ];
});
