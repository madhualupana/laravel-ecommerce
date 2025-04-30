<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => 'Smartphone X',
                'slug' => 'smartphone-x',
                'short_description' => 'Latest smartphone with advanced features',
                'description' => '6.5-inch display, 128GB storage, 48MP camera, long battery life',
                'price' => 699.99,
                'compare_price' => 799.99,
                'category_id' => 1,
                'image' => 'products/smartphone.jpg',
                'gallery' => ['products/smartphone-1.jpg', 'products/smartphone-2.jpg'],
                'is_featured' => true,
                'quantity' => 100,
                'rating' => 4.5,
            ],
            [
                'name' => 'Wireless Headphones',
                'slug' => 'wireless-headphones',
                'short_description' => 'Premium sound quality with noise cancellation',
                'description' => 'Bluetooth 5.0, 30hrs battery life, comfortable over-ear design',
                'price' => 199.99,
                'compare_price' => 249.99,
                'category_id' => 1,
                'image' => 'products/headphones.jpg',
                'gallery' => ['products/headphones-1.jpg', 'products/headphones-2.jpg'],
                'is_featured' => true,
                'quantity' => 50,
                'rating' => 4.2,
            ],
            // Add more products...
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}