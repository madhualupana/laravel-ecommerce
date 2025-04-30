<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Electronics', 'slug' => 'electronics', 'description' => 'Latest electronic gadgets'],
            ['name' => 'Fashion', 'slug' => 'fashion', 'description' => 'Trendy fashion items'],
            ['name' => 'Home & Kitchen', 'slug' => 'home-kitchen', 'description' => 'Everything for your home'],
            ['name' => 'Beauty', 'slug' => 'beauty', 'description' => 'Beauty and personal care'],
            ['name' => 'Sports', 'slug' => 'sports', 'description' => 'Sports and outdoor gear'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}