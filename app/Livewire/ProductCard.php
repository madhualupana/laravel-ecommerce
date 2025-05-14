<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;

class ProductCard extends Component
{
    public $product;
    public $showAddToCart = true;
    public $viewType = 'card'; // 'card' or 'detail'
    public $isInWishlist = false;

    public function mount($product, $showAddToCart = true, $viewType = 'card')
    {
        $this->product = is_array($product) ? (object)$product : $product;
        $this->showAddToCart = $showAddToCart;
        $this->viewType = $viewType;
        
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
            'qty' => 1,
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
            productImage: $imagePath
        );
    }

    public function toggleWishlist()
    {
         // Ensure the image path is correct
         $imagePath = $this->product->image;
        
         // If the image path is relative, prepend with asset()
         if (!str_starts_with($imagePath, 'http')) {
             $imagePath = asset($imagePath);
         }

        if (!Auth::check()) {
            $this->dispatch('notify', 
                message: 'Please login to manage your wishlist',
                type: 'error',
                productName: $this->product->name,
                productImage: $imagePath

            );
            return;
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
        
        $this->dispatch('wishlistUpdated');
    }

    public function render()
    {
        return view("livewire.product-{$this->viewType}");
    }
}