<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

use Gloudemans\Shoppingcart\Facades\Cart;

class ProductCard extends Component
{
    public $product;
    public $showAddToCart = true;

    

    public function mount($product, $showAddToCart = true)
    {
        // Handle both Product object and array input
        $this->product = is_array($product) ? (object)$product : $product;
        $this->showAddToCart = $showAddToCart;
    }


     

   

    public function addToCart()
    {


        \Cart::add([
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
        
        // Updated to use dispatch() instead of dispatchBrowserEvent()
        $this->dispatch('notify', 
            message: 'Product added to cart!',
            productName: $this->product->name,
            productImage: $this->product->image
        );
    }

    public function render()
    {
        return view('livewire.product-card');
    }
}