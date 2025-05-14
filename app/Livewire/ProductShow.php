<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;

class ProductShow extends Component
{
    public $product;
    public $relatedProducts;
    public $quantity = 1;
    public $activeTab = 'description';
    public $isInWishlist = false;

    public function mount(Product $product)
{
    
    $this->product = $product;
    $this->product->images = $product->images ?? []; // Ensure images is always an array
    $this->relatedProducts = Product::where('category_id', $product->category_id)
    ->where('id', '!=', $product->id)
    ->inRandomOrder()
    ->take(4)
    ->get();

    // Check if product is in wishlist for authenticated user
    if (Auth::check()) {
        $this->isInWishlist = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $this->product->id)
            ->exists();
    }
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
        'qty' => $this->quantity, // Changed from hardcoded 1 to $this->quantity
        'price' => $this->product->price,
        'options' => [
            'image' => $imagePath,
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

    public function toggleWishlist()
    {
        if (!Auth::check()) {
            // Redirect to login or show a message
            return redirect()->route('login')->with('error', 'Please login to manage your wishlist');
        }
          // Ensure the image path is correct
          $imagePath = $this->product->image;
        
          // If the image path is relative, prepend with asset()
          if (!str_starts_with($imagePath, 'http')) {
              $imagePath = asset($imagePath);
          }

        if ($this->isInWishlist) {
            // Remove from wishlist
            Wishlist::where('user_id', Auth::id())
                ->where('product_id', $this->product->id)
                ->delete();
            $this->isInWishlist = false;
            $this->dispatch('notify', 
                message: 'Product removed from wishlist',
                 productName: $this->product->name,
                productImage: $imagePath
            );
        } else {
            // Add to wishlist
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $this->product->id
            ]);
            $this->isInWishlist = true;
            $this->dispatch('notify', 
                message: 'Product added to wishlist!',
                productName: $this->product->name,
                productImage: $imagePath
            );
        }
    }

    public function render()
    {
        return view('livewire.product-show')
            ->layout('components.layouts.app', ['title' => $this->product->name]);
    }

    
}