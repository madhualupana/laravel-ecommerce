@extends('layouts.app')

@section('title', 'Shop')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Filters Sidebar -->
            <div class="w-full md:w-64 flex-shrink-0">
                <div class="bg-white rounded-lg shadow-md p-4 sticky top-4">
                    <h3 class="font-bold text-lg mb-4">Filters</h3>
                    
                    <!-- Categories -->
                    <div class="mb-6">
                        <h4 class="font-medium mb-2">Categories</h4>
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('products.index', request()->except('category')) }}" 
                                   class="block px-2 py-1 rounded hover:bg-gray-100 {{ !request()->has('category') ? 'text-primary-600 font-medium' : 'text-gray-700' }}">
                                    All Categories
                                </a>
                            </li>
                            @foreach($categories as $category)
                                <li>
                                    <a href="{{ route('products.index', array_merge(request()->except('category'), ['category' => $category->slug])) }}" 
                                       class="block px-2 py-1 rounded hover:bg-gray-100 {{ request()->category == $category->slug ? 'text-primary-600 font-medium' : 'text-gray-700' }}">
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <!-- Price Range -->
                    <div class="mb-6">
                        <h4 class="font-medium mb-2">Price Range</h4>
                        <div x-data="{ minPrice: {{ request()->min_price ?? $minPrice }}, maxPrice: {{ request()->max_price ?? $maxPrice }}, min: {{ $minPrice }}, max: {{ $maxPrice }} }" 
                             class="space-y-4">
                            <div class="flex items-center justify-between space-x-4">
                                <input type="number" x-model="minPrice" @change.debounce="window.location.href = updateUrlParam('min_price', minPrice)" 
                                       class="w-24 px-2 py-1 border rounded text-sm" min="{{ $minPrice }}" max="{{ $maxPrice }}">
                                <span>to</span>
                                <input type="number" x-model="maxPrice" @change.debounce="window.location.href = updateUrlParam('max_price', maxPrice)" 
                                       class="w-24 px-2 py-1 border rounded text-sm" min="{{ $minPrice }}" max="{{ $maxPrice }}">
                            </div>
                            <div class="relative pt-1">
                                <input type="range" x-model="minPrice" @change.debounce="window.location.href = updateUrlParam('min_price', minPrice)" 
                                       class="absolute w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer" 
                                       min="{{ $minPrice }}" max="{{ $maxPrice }}" step="1">
                                <input type="range" x-model="maxPrice" @change.debounce="window.location.href = updateUrlParam('max_price', maxPrice)" 
                                       class="absolute w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer" 
                                       min="{{ $minPrice }}" max="{{ $maxPrice }}" step="1">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Clear Filters -->
                    @if(request()->has('category') || request()->has('min_price') || request()->has('max_price') || request()->has('search'))
                        <a href="{{ route('products.index') }}" class="text-primary-600 hover:text-primary-800 text-sm font-medium">
                            Clear All Filters
                        </a>
                    @endif
                </div>
            </div>
            
            <!-- Product Listing -->
            <div class="flex-1">
                <!-- Search and Sort -->
                <div class="bg-white rounded-lg shadow-md p-4 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div class="w-full md:w-auto">
                        <div class="relative">
                            <input type="text" placeholder="Search products..." 
                                   value="{{ request()->search }}" 
                                   class="w-full md:w-64 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                                   x-data
                                   @input.debounce.500ms="window.location.href = '{{ route('products.index', request()->except('search')) }}' + (value ? '&search=' + encodeURIComponent(value) : '')">
                            <svg class="absolute right-3 top-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600">Sort by:</span>
                        <select class="border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500"
                                x-data
                                @change="window.location.href = '{{ route('products.index', request()->except('sort')) }}' + '&sort=' + $event.target.value">
                            <option value="latest" {{ request()->sort == 'latest' ? 'selected' : '' }}>Latest</option>
                            <option value="price_asc" {{ request()->sort == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_desc" {{ request()->sort == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="rating" {{ request()->sort == 'rating' ? 'selected' : '' }}>Top Rated</option>
                        </select>
                    </div>
                </div>
                
                <!-- Products Grid -->
                @if($products->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($products as $product)
                            <livewire:product-card
                                :product="$product" 
                                viewType="card"
                                :key="'product-card-'.$product->id"
                            />
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="bg-white rounded-lg shadow-md p-8 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900">No products found</h3>
                        <p class="mt-1 text-gray-500">Try adjusting your search or filter to find what you're looking for.</p>
                        <div class="mt-6">
                            <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700">
                                Clear Filters
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection