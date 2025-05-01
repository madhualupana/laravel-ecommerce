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
    <h4 class="font-medium mb-3 text-gray-700">Price Range</h4>
    <div x-data="priceRangeFilter(
        {{ $minPrice }}, 
        {{ $maxPrice }}, 
        {{ request()->min_price ?? 'null' }}, 
        {{ request()->max_price ?? 'null' }}
    )" class="space-y-5">
        <!-- Range Slider - Improved Version -->
        <div class="relative pt-6 pb-4 px-2">
            <!-- Track Background -->
            <div class="absolute h-2 w-full bg-gray-100 rounded-full top-1/2 -translate-y-1/2"></div>
            
            <!-- Active Range -->
            <div class="absolute h-2 bg-primary-500 rounded-full top-1/2 -translate-y-1/2" 
                 :style="`left: ${minPercent}%; width: ${maxPercent - minPercent}%`"></div>
            
            <!-- Price Labels -->
            <div class="flex justify-between text-xs text-gray-500 mb-1">
                <span x-text="formatCurrency(absoluteMin)"></span>
                <span x-text="formatCurrency(absoluteMax)"></span>
            </div>
            
            <!-- Thumb for Min Price -->
            <input type="range" 
                   x-model="currentMinPrice" 
                   @input.debounce.500ms="updateMinPrice"
                   :min="absoluteMin" 
                   :max="absoluteMax" 
                   class="absolute w-full h-3 opacity-0 cursor-pointer z-20 top-6">
            
            <!-- Thumb for Max Price -->
            <input type="range" 
                   x-model="currentMaxPrice" 
                   @input.debounce.500ms="updateMaxPrice"
                   :min="absoluteMin" 
                   :max="absoluteMax" 
                   class="absolute w-full h-3 opacity-0 cursor-pointer z-20 top-6">
            
            <!-- Visual Thumbs - Improved -->
            <div class="absolute h-5 w-5 bg-white border-2 border-primary-500 rounded-full shadow-md top-1/2 -translate-y-1/2 z-10 transform hover:scale-125 transition-transform"
                 :style="`left: ${minPercent}%`"
                 @mousedown="activeThumb = 'min'">
                <div class="absolute -top-6 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded whitespace-nowrap"
                     x-text="formatCurrency(currentMinPrice)"
                     x-show="activeThumb === 'min'"></div>
            </div>
            <div class="absolute h-5 w-5 bg-white border-2 border-primary-500 rounded-full shadow-md top-1/2 -translate-y-1/2 z-10 transform hover:scale-125 transition-transform"
                 :style="`left: ${maxPercent}%`"
                 @mousedown="activeThumb = 'max'">
                <div class="absolute -top-6 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded whitespace-nowrap"
                     x-text="formatCurrency(currentMaxPrice)"
                     x-show="activeThumb === 'max'"></div>
            </div>
        </div>
        
        <!-- Number Inputs - Improved -->
        <div class="flex items-center justify-between space-x-4">
            <div class="relative flex-1">
                <label class="block text-xs text-gray-500 mb-1">Min</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">$</span>
                    <input type="number" 
                           x-model="currentMinPrice" 
                           @change.debounce.500ms="updateMinPrice"
                           :min="absoluteMin" 
                           :max="currentMaxPrice" 
                           class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>
            </div>
            <div class="pt-6 text-gray-400">to</div>
            <div class="relative flex-1">
                <label class="block text-xs text-gray-500 mb-1">Max</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">$</span>
                    <input type="number" 
                           x-model="currentMaxPrice" 
                           @change.debounce.500ms="updateMaxPrice"
                           :min="currentMinPrice" 
                           :max="absoluteMax" 
                           class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>
            </div>
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
                            
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-2">
    <span class="text-sm text-gray-600">Sort by:</span>
    <select 
        class="border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500"
        x-data
        @change="window.location.href = updateUrlWithSort($event.target.value)"
    >
        @foreach($sortOptions as $value => $option)
            <option 
                value="{{ $value }}" 
                {{ $currentSort == $value ? 'selected' : '' }}
            >
                {{ $option['label'] }}
            </option>
        @endforeach
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

    <script>

document.addEventListener('alpine:init', () => {
    Alpine.data('priceRangeFilter', (absoluteMin, absoluteMax, initialMin, initialMax) => ({
        absoluteMin,
        absoluteMax,
        currentMinPrice: initialMin || absoluteMin,
        currentMaxPrice: initialMax || absoluteMax,
        activeThumb: null,
        
        init() {
            // Handle mouseup globally to deactivate thumb
            document.addEventListener('mouseup', () => {
                this.activeThumb = null;
            });
            
            // Handle mousemove for dragging thumbs
            document.addEventListener('mousemove', (e) => {
                if (!this.activeThumb) return;
                
                const slider = this.$el.querySelector('.relative');
                const rect = slider.getBoundingClientRect();
                const percent = Math.min(1, Math.max(0, (e.clientX - rect.left) / rect.width));
                const value = Math.round(this.absoluteMin + percent * (this.absoluteMax - this.absoluteMin));
                
                if (this.activeThumb === 'min') {
                    this.currentMinPrice = Math.min(value, this.currentMaxPrice);
                } else {
                    this.currentMaxPrice = Math.max(value, this.currentMinPrice);
                }
                
                this.updateUrl(this.activeThumb === 'min' ? 'min_price' : 'max_price', 
                              this.activeThumb === 'min' ? this.currentMinPrice : this.currentMaxPrice);
            });
        },
        
        get minPercent() {
            return ((this.currentMinPrice - this.absoluteMin) / (this.absoluteMax - this.absoluteMin)) * 100;
        },
        
        get maxPercent() {
            return ((this.currentMaxPrice - this.absoluteMin) / (this.absoluteMax - this.absoluteMin)) * 100;
        },
        
        formatCurrency(value) {
            return new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(value);
        },
        
        updateMinPrice() {
            this.currentMinPrice = Math.max(this.absoluteMin, 
                                          Math.min(this.currentMaxPrice, 
                                                 parseInt(this.currentMinPrice) || this.absoluteMin));
            this.updateUrl('min_price', this.currentMinPrice);
        },
        
        updateMaxPrice() {
            this.currentMaxPrice = Math.min(this.absoluteMax, 
                                          Math.max(this.currentMinPrice, 
                                                 parseInt(this.currentMaxPrice) || this.absoluteMax));
            this.updateUrl('max_price', this.currentMaxPrice);
        },
        
        updateUrl(param, value) {
            const url = new URL(window.location.href);
            const params = new URLSearchParams(url.search);
            
            params.delete('page');
            
            if ((param === 'min_price' && value === this.absoluteMin) || 
                (param === 'max_price' && value === this.absoluteMax)) {
                params.delete(param);
            } else {
                params.set(param, value);
            }
            
            window.location.href = `${url.pathname}?${params.toString()}`;
        }
    }));
});



     function updateUrlWithSort(sortValue) {
        const url = new URL(window.location.href);
        const params = new URLSearchParams(url.search);
        
        // Remove existing sort parameter
        params.delete('sort');
        
        // Add new sort parameter if not default
        if (sortValue && sortValue !== 'latest') {
            params.append('sort', sortValue);
        }
        
        // Reset to page 1 when changing sort
        params.delete('page');
        
        return `${url.pathname}?${params.toString()}`;
    }
    
    // Also update your price range function to be consistent
    function updateUrlParam(key, value) {
        const url = new URL(window.location.href);
        const params = new URLSearchParams(url.search);
        
        if (value) {
            params.set(key, value);
        } else {
            params.delete(key);
        }
        
        // Reset to page 1 when changing filters
        params.delete('page');
        
        return `${url.pathname}?${params.toString()}`;
    }
</script>
@endsection