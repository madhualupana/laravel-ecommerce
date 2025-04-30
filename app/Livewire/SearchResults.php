<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class SearchResults extends Component
{
    public $search;

    public function render()
    {
        $results = [];

        if (strlen($this->search) >= 2) {
            $results = Product::where('name', 'like', '%' . $this->search . '%')
                ->where('is_active', true)
                ->take(5)
                ->get();
        }

        return view('livewire.search-results', [
            'results' => $results,
        ]);
    }
}