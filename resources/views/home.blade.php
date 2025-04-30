@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <!-- Hero Carousel -->
    <div class="mb-12">
        @livewire('hero-carousel')
    </div>

    <!-- Categories -->
    <div class="mb-12">
        <h2 class="text-2xl font-bold mb-6">Shop by Category</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($categories as $category)
                <a href="{{ route('categories.show', $category) }}" class="group block overflow-hidden rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <div class="relative h-40 bg-gray-100">
                        <img src="{{ $category->image ?? 'https://placehold.co/300' }}" alt="{{ $category->name }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center">
                            <h3 class="text-white font-semibold text-lg group-hover:text-primary-400 transition duration-300">{{ $category->name }}</h3>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Featured Products -->
    <div class="mb-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Featured Products</h2>
            <a href="{{ route('products.index') }}" class="text-primary-600 hover:text-primary-800 font-medium">View All</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
                @livewire('product-card', ['product' => $product], key($product->id))
            @endforeach
        </div>
    </div>

    <!-- New Arrivals -->
    <div class="mb-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">New Arrivals</h2>
            <a href="{{ route('products.index', ['sort' => 'latest']) }}" class="text-primary-600 hover:text-primary-800 font-medium">View All</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($newArrivals as $product)
                @livewire('product-card', ['product' => $product], key($product->id))
            @endforeach
        </div>
    </div>

    <!-- Trending Products -->
    <div class="mb-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Trending Now</h2>
            <a href="{{ route('products.index', ['sort' => 'rating']) }}" class="text-primary-600 hover:text-primary-800 font-medium">View All</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($trendingProducts as $product)
                @livewire('product-card', ['product' => $product], key($product->id))
            @endforeach
        </div>
    </div>

    <!-- Promo Banner -->
    <div class="mb-12 bg-gradient-to-r from-primary-500 to-secondary-600 rounded-lg p-8 text-white">
        <div class="max-w-2xl mx-auto text-center">
            <h2 class="text-3xl font-bold mb-4">Summer Sale!</h2>
            <p class="text-lg mb-6">Up to 50% off on selected items. Limited time offer.</p>
            <a href="#" class="inline-block bg-white text-primary-600 font-bold px-6 py-3 rounded-lg hover:bg-gray-100 transition duration-300">Shop Now</a>
        </div>
    </div>
@endsection