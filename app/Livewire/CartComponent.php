<?php

namespace App\Livewire;

use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartComponent extends Component
{
    protected $listeners = ['cartUpdated' => '$refresh'];

    public function removeFromCart($rowId)
    {
        Cart::remove($rowId);
        $this->dispatch('cartUpdated');
    }

    public function updateQuantity($rowId, $quantity)
    {
        Cart::update($rowId, $quantity);
        $this->dispatch('cartUpdated');
    }

    public function render()
    {
        return view('livewire.cart');
    }
}