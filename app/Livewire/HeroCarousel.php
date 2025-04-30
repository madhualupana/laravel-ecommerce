<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class HeroCarousel extends Component
{
    public $slides = [
        [
            'title' => 'Summer Collection',
            'subtitle' => 'New Arrivals',
            'image' => 'https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
            'link' => '#',
            'button_text' => 'Shop Now',
        ],
        [
            'title' => 'Electronics Sale',
            'subtitle' => 'Up to 50% Off',
            'image' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
            'link' => '#',
            'button_text' => 'Discover Deals',
        ],
        [
            'title' => 'Limited Edition',
            'subtitle' => 'Exclusive Items',
            'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
            'link' => '#',
            'button_text' => 'View Collection',
        ],
    ];

    public $currentSlide = 0;

    public function nextSlide()
    {
        $this->currentSlide = ($this->currentSlide + 1) % count($this->slides);
    }

    public function prevSlide()
    {
        $this->currentSlide = ($this->currentSlide - 1 + count($this->slides)) % count($this->slides);
    }

    public function goToSlide($index)
    {
        $this->currentSlide = $index;
    }

    public function render()
    {
        return view('livewire.hero-carousel');
    }
}