<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class Orders extends Component
{
    use WithPagination;

    public $status = '';
    protected $queryString = ['status'];

    public function mount()
    {
        // Initialize status from request if present
        $this->status = request('status') ?? '';
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function render()
    {
        $orders = auth()->user()->orders()
            ->when($this->status, function($query) {
                return $query->where('status', $this->status);
            })
            ->with('items.product')
            ->latest()
            ->paginate(10);

        return view('livewire.orders', [
            'orders' => $orders
        ]);
    }
}