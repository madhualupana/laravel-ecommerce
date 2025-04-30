<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

use Gloudemans\Shoppingcart\Facades\Cart;

class ProductDetail extends Component
{
    public Product $product;

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function addToCart()
    {
        Cart::add([
            'id' => $this->product->id,
            'name' => $this->product->name,
            'qty' => 1,
            'price' => $this->product->price,
            'options' => [
                'image' => $this->product->image, // or your image path logic
            ]
        ]);
        $this->dispatch('cartUpdated');
        
        // Updated to use dispatch() instead of dispatchBrowserEvent()
        $this->dispatch('notify', 
            message: 'Product added to cart!',
            productName: $this->product->name,
            productImage: $this->product->image
        );
    }

    public function render()
    {
        return view('livewire.product-detail');
    }
}
