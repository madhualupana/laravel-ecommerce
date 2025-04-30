<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;

class Navigation extends Component
{
    public $search = '';
    public $cartCount = 0;

    protected $listeners = ['cartUpdated' => 'updateCartCount'];

    public function mount()
    {
        $this->updateCartCount();
    }

    public function updateCartCount()
    {
        $this->cartCount = \Cart::count();
    }

    public function render()
    {
        $categories = Category::where('is_active', true)->get();
        
        return view('livewire.navigation', [
            'categories' => $categories,
        ]);
    }
}