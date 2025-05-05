<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;
use App\Models\Product;

class CategoryShow extends Component
{
    use WithPagination;

    public $category;
    public $perPage = 12;

    public function mount(Category $category)
    {
        $this->category = $category;
    }

    public function render()
    {
        $products = Product::where('category_id', $this->category->id)
            ->where('is_active', true)
            ->paginate($this->perPage);

        return view('livewire.category-show', [
            'products' => $products
        ])->layout('components.layouts.app', [
            'title' => $this->category->name
        ]);
    }
}