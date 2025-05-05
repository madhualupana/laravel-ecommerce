<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Product;

class HomePage extends Component
{
    public function render()
    {

        $featuredProducts = Product::where('is_featured', true)
            ->where('is_active', true)
            ->inRandomOrder()
            ->take(8)
            ->get();
        $newArrivals = Product::where('is_active', true)
            ->latest()
            ->take(8)
            ->get();

        $trendingProducts = Product::where('is_active', true)
            ->orderBy('rating', 'desc')
            ->take(8)
            ->get();

        // Get active categories with at least one product
        $categories = Category::where('is_active', true)
            ->withCount('products')
            ->having('products_count', '>', 0)
            ->take(6)
            ->get();

        return view('livewire.home-page', [
            'featuredProducts' => $featuredProducts,
            'newArrivals' => $newArrivals,
            'trendingProducts' => $trendingProducts,
            'categories' => $categories
        ])->layout('components.layouts.app', [
            'title' => 'Home'
        ]);
    }
}