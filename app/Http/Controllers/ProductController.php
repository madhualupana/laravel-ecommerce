<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()->where('is_active', true);

        // Search
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by price range
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sorting
        $sortOptions = [
            'price_asc' => ['field' => 'price', 'direction' => 'asc'],
            'price_desc' => ['field' => 'price', 'direction' => 'desc'],
            'latest' => ['field' => 'created_at', 'direction' => 'desc'],
            'rating' => ['field' => 'rating', 'direction' => 'desc'],
        ];

        $sort = $request->get('sort', 'latest');
        $sortOption = $sortOptions[$sort] ?? $sortOptions['latest'];
        $query->orderBy($sortOption['field'], $sortOption['direction']);

        $products = $query->paginate(12);

        $categories = Category::where('is_active', true)->get();
        $minPrice = Product::min('price');
        $maxPrice = Product::max('price');

        return view('products.index', compact('products', 'categories', 'minPrice', 'maxPrice'));
    }

    public function show(Product $product)
    {
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}