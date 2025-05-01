<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    protected $sortOptions = [
        'latest' => [
            'field' => 'products.created_at',
            'direction' => 'desc',
            'label' => 'Latest'
        ],
        'price_asc' => [
            'field' => 'products.price',
            'direction' => 'asc',
            'label' => 'Price: Low to High'
        ],
        'price_desc' => [
            'field' => 'products.price',
            'direction' => 'desc',
            'label' => 'Price: High to Low'
        ],
        'rating' => [
            'field' => 'products.rating',
            'direction' => 'desc',
            'label' => 'Top Rated'
        ],
        'popular' => [
            'field' => 'sales_count',
            'direction' => 'desc',
            'label' => 'Most Popular',
            'is_custom' => true // Flag for custom sorting logic
        ],
    ];

    public function index(Request $request)
    {
        $query = Product::query()->where('is_active', true);

        // Search
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('products.name', 'like', '%' . $request->search . '%')
                  ->orWhere('products.description', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by category
        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Price range filtering
        $query->when($request->min_price, function($q) use ($request) {
            $q->where('products.price', '>=', $request->min_price);
        })->when($request->max_price, function($q) use ($request) {
            $q->where('products.price', '<=', $request->max_price);
        });

        // Sorting
        $sort = $request->get('sort', 'latest');
        $sortOption = $this->sortOptions[$sort] ?? $this->sortOptions['latest'];

        // Handle custom sorting (sales_count)
        if (isset($sortOption['is_custom']) && $sortOption['is_custom']) {
            $this->applySalesCountSort($query);
        } else {
            $query->orderBy($sortOption['field'], $sortOption['direction']);
        }

        $products = $query->paginate(12)->appends($request->query());

        $categories = Category::where('is_active', true)->get();
        $minPrice = Product::min('price');
        $maxPrice = Product::max('price');

        return view('products.index', [
            'products' => $products,
            'categories' => $categories,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'sortOptions' => $this->sortOptions,
            'currentSort' => $sort
        ]);
    }

    protected function applySalesCountSort($query)
    {
        $query->select('products.*')
            ->leftJoin('order_items', 'order_items.product_id', '=', 'products.id')
            ->leftJoin('orders', function($join) {
                $join->on('orders.id', '=', 'order_items.order_id')
                     ->where('orders.status', 'completed');
            })
            ->selectRaw('COALESCE(SUM(order_items.quantity), 0) as sales_count')
            ->groupBy('products.id')
            ->orderBy('sales_count', 'desc');
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