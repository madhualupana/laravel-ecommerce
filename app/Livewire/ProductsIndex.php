<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;

class ProductsIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $category = '';
    public $minPrice;
    public $maxPrice;
    public $sort = 'latest';
    
    protected $queryString = [
        'search' => ['except' => ''],
        'category' => ['except' => ''],
        'minPrice' => ['except' => ''],
        'maxPrice' => ['except' => ''],
        'sort' => ['except' => 'latest'],
        'page' => ['except' => 1],
    ];

    protected $sortOptions = [
        'latest' => [
            'field' => 'created_at',
            'direction' => 'desc',
            'label' => 'Latest'
        ],
        'price_asc' => [
            'field' => 'price',
            'direction' => 'asc',
            'label' => 'Price: Low to High'
        ],
        'price_desc' => [
            'field' => 'price',
            'direction' => 'desc',
            'label' => 'Price: High to Low'
        ],
        'rating' => [
            'field' => 'rating',
            'direction' => 'desc',
            'label' => 'Top Rated'
        ],
        'popular' => [
            'field' => 'sales_count',
            'direction' => 'desc',
            'label' => 'Most Popular',
            'is_custom' => true
        ],
    ];

    public function mount()
    {
        $this->minPrice = $this->minPrice ?: Product::min('price');
        $this->maxPrice = $this->maxPrice ?: Product::max('price');
    }

    public function updatedSort($value)
    {
        $this->resetPage();
        $this->render(); // Force re-render
    }

    public function render()
    {
        $query = Product::query()->where('is_active', true);

        // Search
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Filter by category
        if ($this->category) {
            $query->whereHas('category', function($q) {
                $q->where('slug', $this->category);
            });
        }

        // Price range filtering
        $query->when($this->minPrice, function($q) {
            $q->where('products.price', '>=', $this->minPrice); // Changed 'price' to 'products.price'
        })->when($this->maxPrice, function($q) {
            $q->where('products.price', '<=', $this->maxPrice); // Changed 'price' to 'products.price'
        });

        // Sorting
        $sortOption = $this->sortOptions[$this->sort] ?? $this->sortOptions['latest'];

        if (isset($sortOption['is_custom']) && $sortOption['is_custom']) {
            $this->applySalesCountSort($query);
        } else {
            $query->orderBy($sortOption['field'], $sortOption['direction']);
        }

        $products = $query->paginate(12);
        $categories = Category::where('is_active', true)->get();
        $absoluteMinPrice = Product::min('price');
        $absoluteMaxPrice = Product::max('price');

        return view('livewire.products-index', [
            'products' => $products,
            'categories' => $categories,
            'absoluteMinPrice' => $absoluteMinPrice,
            'absoluteMaxPrice' => $absoluteMaxPrice,
            'sortOptions' => $this->sortOptions,
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

    public function updated()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['search', 'category', 'minPrice', 'maxPrice', 'sort']);
        $this->resetPage();
    }
}