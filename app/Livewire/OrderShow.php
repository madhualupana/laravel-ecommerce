<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;

class OrderShow extends Component
{
    public Order $order;

    public function mount(Order $order)
    {
        // Authorization - user can only view their own orders
        if (auth()->id() !== $order->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $this->order = $order->load('items.product');
    }

    public function render()
    {
        return view('livewire.order-show');
    }
}