<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;

class Footer extends Component
{
    public function render()
    {
        $categories = Category::where('is_active', true)->get();
        
        return view('livewire.footer', [
            'categories' => $categories
        ]);
    }
}