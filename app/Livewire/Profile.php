<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class Profile extends Component
{
    use WithPagination;

    public $status = 'all';
    public $user;

    public function mount()
    {
        $this->user = auth()->user();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function render()
    {
        $orders = $this->user->orders()
            ->when($this->status !== 'all', function($query) {
                return $query->where('status', $this->status);
            })
            ->with('items.product')
            ->latest()
            ->paginate(5);

        return view('livewire.profile', [
            'orders' => $orders
        ]);
    }
}