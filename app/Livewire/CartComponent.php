<?php

namespace App\Livewire;

use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Coupon;

class CartComponent extends Component
{
    public $couponCode;

    protected $listeners = ['cartUpdated' => '$refresh'];

    public function removeFromCart($rowId)
    {
        Cart::remove($rowId);
        $this->dispatch('cartUpdated');
    }

    public function updateQuantity($rowId, $quantity)
    {
        if ($quantity > 0) {
            Cart::update($rowId, $quantity);
            $this->dispatch('cartUpdated');
        }
    }

    public function increaseQuantity($rowId)
    {
        $item = Cart::get($rowId);
        Cart::update($rowId, $item->qty + 1);
        $this->dispatch('cartUpdated');
    }

    public function decreaseQuantity($rowId)
    {
        $item = Cart::get($rowId);
        if ($item->qty > 1) {
            Cart::update($rowId, $item->qty - 1);
            $this->dispatch('cartUpdated');
        }
    }

    public function applyCoupon()
    {
        $coupon = Coupon::where('code', $this->couponCode)->first();

        if ($coupon) {
            session()->put('coupon', [
                'name' => $coupon->code,
                'discount' => $coupon->discount(Cart::subtotal())
            ]);
            $this->dispatch('cartUpdated');
        } else {
            $this->addError('couponCode', 'Invalid coupon code');
        }
    }

    public function removeCoupon()
    {
        session()->forget('coupon');
        $this->dispatch('cartUpdated');
    }

    public function render()
{
    $cartContent = Cart::content()->map(function ($item) {
        // Ensure options is always an array
        $options = method_exists($item->options, 'all') ? 
                 $item->options->all() : 
                 (array)$item->options;
        
        return [
            'rowId' => $item->rowId,
            'id' => $item->id,
            'name' => $item->name,
            'qty' => $item->qty,
            'price' => $item->price,
            'options' => $options, // Make sure this contains the image
            'subtotal' => $item->subtotal
        ];
    })->values()->toArray();

    return view('livewire.cart', [
        'cartContent' => $cartContent,
        'subtotal' => Cart::subtotal(),
        'tax' => Cart::tax(),
        'total' => Cart::total()
    ]);
}
}
