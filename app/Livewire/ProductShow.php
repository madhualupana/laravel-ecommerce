<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;

class ProductShow extends Component
{
    public $product;
    public $relatedProducts;
    public $quantity = 1;
    public $activeTab = 'description';

    public function mount(Product $product)
{
    
    $this->product = $product;
    $this->product->images = $product->images ?? []; // Ensure images is always an array
    $this->relatedProducts = Product::where('category_id', $product->category_id)
        ->where('id', '!=', $product->id)
        ->inRandomOrder()
        ->take(4)
        ->get();
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

public function getImagesAttribute($value)
{
    return $value ? json_decode($value, true) : [];
}

    public function increaseQuantity()
    {
        if ($this->quantity < 10) {
            $this->quantity++;
        }
    }

    public function decreaseQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function changeImage($src)
{
    $this->dispatch('imageChanged', src: $src);
}

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('livewire.product-show')
            ->layout('components.layouts.app', ['title' => $this->product->name]);
    }
}