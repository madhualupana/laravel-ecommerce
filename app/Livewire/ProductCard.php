<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

use Gloudemans\Shoppingcart\Facades\Cart;

class ProductCard extends Component
{
    public $product;
    public $showAddToCart = true;

    public function mount(Product $product, $showAddToCart = true)
    {
        $this->product = $product;
        $this->showAddToCart = $showAddToCart;
    }

    public function addToCart()
    {
        Cart::add([
            'id' => $this->product->id,
            'name' => $this->product->name,
            'price' => $this->product->price,
            'qty' => 1,  // Changed from 'quantity' to 'qty'
            'options' => [  // Changed from 'attributes' to 'options'
                'image' => $this->product->image,
                'slug' => $this->product->slug,
            ],
        ]);

        $this->dispatch('cartUpdated');
    }

    public function render()
    {
        return view('livewire.product-card');
    }
}