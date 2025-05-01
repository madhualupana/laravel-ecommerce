<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class SearchResults extends Component
{
    public $search;

    protected $queryString = ['search'];

    public function render()
    {
        if(strlen($this->search) < 2) {
            return view('livewire.search-results', [
                'results' => collect()
            ]);
        }

        $results = Product::query()
            ->where('name', 'like', '%'.$this->search.'%')
            ->orWhere('description', 'like', '%'.$this->search.'%')
            ->limit(5)
            ->get();

        return view('livewire.search-results', [
            'results' => $results
        ]);
    }
}