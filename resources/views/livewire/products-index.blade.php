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
                            <button wire:click="$set('category', '')" 
                               class="block px-2 py-1 rounded hover:bg-gray-100 {{ !$category ? 'text-primary-600 font-medium' : 'text-gray-700' }}">
                                All Categories
                            </button>
                        </li>
                        @foreach($categories as $categoryItem)
                            <li>
                                <button wire:click="$set('category', '{{ $categoryItem->slug }}')" 
                                   class="block px-2 py-1 rounded hover:bg-gray-100 {{ $category === $categoryItem->slug ? 'text-primary-600 font-medium' : 'text-gray-700' }}">
                                    {{ $categoryItem->name }}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
                
                <!-- Price Range -->
                <div class="mb-6">
                    <h4 class="font-medium mb-3 text-gray-700">Price Range</h4>
                    <div class="space-y-5">
                        <!-- Range Slider -->
                        <div class="relative pt-6 pb-4 px-2">
                            <!-- Track Background -->
                            <div class="absolute h-2 w-full bg-gray-100 rounded-full top-1/2 -translate-y-1/2"></div>
                            
                            <!-- Active Range -->
                            <div class="absolute h-2 bg-primary-500 rounded-full top-1/2 -translate-y-1/2" 
                                 style="left: {{ ($minPrice - $absoluteMinPrice) / ($absoluteMaxPrice - $absoluteMinPrice) * 100 }}%; 
                                        width: {{ ($maxPrice - $minPrice) / ($absoluteMaxPrice - $absoluteMinPrice) * 100 }}%"></div>
                            
                            <!-- Price Labels -->
                            <div class="flex justify-between text-xs text-gray-500 mb-1">
                                <span>{{ number_format($absoluteMinPrice, 0) }}</span>
                                <span>{{ number_format($absoluteMaxPrice, 0) }}</span>
                            </div>
                            
                            <!-- Min Price Thumb -->
                            <input type="range" 
                                   wire:model.lazy="minPrice"
                                   min="{{ $absoluteMinPrice }}" 
                                   max="{{ $absoluteMaxPrice }}" 
                                   class="absolute w-full h-3 opacity-0 cursor-pointer z-20 top-6">
                            
                            <!-- Max Price Thumb -->
                            <input type="range" 
                                   wire:model.lazy="maxPrice"
                                   min="{{ $absoluteMinPrice }}" 
                                   max="{{ $absoluteMaxPrice }}" 
                                   class="absolute w-full h-3 opacity-0 cursor-pointer z-20 top-6">
                            
                            <!-- Visual Thumbs -->
                            <div class="absolute h-5 w-5 bg-white border-2 border-primary-500 rounded-full shadow-md top-1/2 -translate-y-1/2 z-10 transform hover:scale-125 transition-transform"
                                 style="left: {{ ($minPrice - $absoluteMinPrice) / ($absoluteMaxPrice - $absoluteMinPrice) * 100 }}%">
                                <div class="absolute -top-6 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded whitespace-nowrap">
                                    ${{ number_format($minPrice, 0) }}
                                </div>
                            </div>
                            <div class="absolute h-5 w-5 bg-white border-2 border-primary-500 rounded-full shadow-md top-1/2 -translate-y-1/2 z-10 transform hover:scale-125 transition-transform"
                                 style="left: {{ ($maxPrice - $absoluteMinPrice) / ($absoluteMaxPrice - $absoluteMinPrice) * 100 }}%">
                                <div class="absolute -top-6 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded whitespace-nowrap">
                                    ${{ number_format($maxPrice, 0) }}
                                </div>
                            </div>
                        </div>
                        
                        <!-- Number Inputs -->
                        <div class="flex items-center justify-between space-x-4">
                            <div class="relative flex-1">
                                <label class="block text-xs text-gray-500 mb-1">Min</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">$</span>
                                    <input type="number" 
                                           wire:model.lazy="minPrice"
                                           min="{{ $absoluteMinPrice }}" 
                                           max="{{ $maxPrice }}" 
                                           class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                </div>
                            </div>
                            <div class="pt-6 text-gray-400">to</div>
                            <div class="relative flex-1">
                                <label class="block text-xs text-gray-500 mb-1">Max</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">$</span>
                                    <input type="number" 
                                           wire:model.lazy="maxPrice"
                                           min="{{ $minPrice }}" 
                                           max="{{ $absoluteMaxPrice }}" 
                                           class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Clear Filters -->
                @if($search || $category || $minPrice != $absoluteMinPrice || $maxPrice != $absoluteMaxPrice || $sort != 'latest')
                    <button wire:click="clearFilters" class="text-primary-600 hover:text-primary-800 text-sm font-medium">
                        Clear All Filters
                    </button>
                @endif
            </div>
        </div>
         
        <!-- Product Listing -->
        <div class="flex-1">
            <!-- Search and Sort -->
            <div class="bg-white rounded-lg shadow-md p-4 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="w-full md:w-auto">
                <input wire:model.live.debounce.500ms="search" type="text"
                        placeholder="Search products..."
                        class="w-64 px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">

                    <div wire:loading.class.remove="hidden"
                        class="hidden absolute right-3 top-2.5">
                        <svg class="animate-spin h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </div>

                  
                </div>
                
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600">Sort by:</span>
  <select  wire:model.live="sort" class="border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500"
                    >
                    @foreach($sortOptions as $value => $option)
                        <option value="{{ $value }}" @selected($sort === $value)>
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
                    {{ $products->links() }}
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">No products found</h3>
                    <p class="mt-1 text-gray-500">Try adjusting your search or filter to find what you're looking for.</p>
                    <div class="mt-6">
                        <button wire:click="clearFilters" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700">
                            Clear Filters
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>