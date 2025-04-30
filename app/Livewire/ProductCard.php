<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;

class ProductCard extends Component
{
    public $product;
    public $showAddToCart = true;
    public $viewType = 'card'; // 'card' or 'detail'

    public function mount($product, $showAddToCart = true, $viewType = 'card')
    {
        $this->product = is_array($product) ? (object)$product : $product;
        $this->showAddToCart = $showAddToCart;
        $this->viewType = $viewType;
    }

    public function addToCart()
{
    // Ensure the image path is correct
    $imagePath = $this->product->image;
    
    // If the image path is relative, prepend with asset()
    if (!str_starts_with($imagePath, 'http')) {
        $imagePath = asset($imagePath);
    }

    Cart::add([
        'id' => $this->product->id,
        'name' => $this->product->name,
        'qty' => 1,
        'price' => $this->product->price,
        'options' => [
            'image' => $imagePath, // Use the properly formatted path
            'slug' => $this->product->slug ?? null,
        ]
    ]);
      
    $this->dispatch('cartUpdated');
    $this->dispatch('notify', 
        message: 'Product added to cart!',
        productName: $this->product->name,
        productImage: $imagePath // Use the same formatted path here
    );
 }

    public function render()
    {
        return view("livewire.product-{$this->viewType}");
    }
}