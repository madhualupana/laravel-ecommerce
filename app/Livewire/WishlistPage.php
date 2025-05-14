<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;

class WishlistPage extends Component
{

    public $product;

    public function mount()
    {
        // Redirect if not authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }
    }

    public function removeFromWishlist($productId)
    {
        $product = Product::findOrFail($productId);
        
        // Ensure the image path is correct
        $imagePath = $product->image;
        
        // If the image path is relative, prepend with asset()
        if (!str_starts_with($imagePath, 'http')) {
            $imagePath = asset($imagePath);
        }
        
        Wishlist::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->delete();
            
        $this->dispatch('notify', 
            message: 'Product removed from wishlist',
            type: 'success',
            productName: $product->name,
            productImage: $imagePath
        );
    }

    public function addToCartFromWishlist($productId)
    {
        $product = Product::findOrFail($productId);
        
        // Ensure the image path is correct
        $imagePath = $product->image;
        
        // If the image path is relative, prepend with asset()
        if (!str_starts_with($imagePath, 'http')) {
            $imagePath = asset($imagePath);
        }

        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => 1,
            'price' => $product->price,
            'options' => [
                'image' => $imagePath,
                'slug' => $product->slug ?? null,
            ]
        ]);
          
        $this->dispatch('cartUpdated');
        $this->dispatch('notify', 
            message: 'Product added to cart!',
            productName: $product->name,
            productImage: $imagePath
        );
    }

    public function render()
    {
        $wishlistItems = Auth::check() 
            ? Auth::user()->wishlistItems()->with('product')->paginate(12)
            : collect();
            
        return view('livewire.wishlist-page', [
            'wishlistItems' => $wishlistItems
        ])->layout('components.layouts.app', ['title' => 'My Wishlist']);
    }
}