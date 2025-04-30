<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
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

        return view('home', compact(
            'featuredProducts',
            'newArrivals',
            'trendingProducts',
            'categories'  // Make sure this is included
        ));
    }
}