<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
    <!-- Product Image -->
    <div class="relative">
        <a href="{{ route('products.show', $product) }}">
            <img src="{{ asset('/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
        </a>
        
        @if($product->compare_price && $product->compare_price > $product->price)
            <div class="absolute top-2 right-2 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                -{{ $product->discount_percentage }}%
            </div>
        @endif
        
        @if($product->is_featured)
            <div class="absolute top-2 left-2 bg-primary-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                Featured
            </div>
        @endif
    </div>
    
    <!-- Product Details -->
    <div class="p-4">
        <div class="flex justify-between items-start">
            <div>
                <a href="{{ route('products.show', $product) }}" class="font-semibold text-gray-800 hover:text-primary-600 transition duration-300">
                    {{ $product->name }}
                </a>
                <p class="text-sm text-gray-600 mt-1 line-clamp-2">{{ $product->short_description }}</p>
            </div>
            
            <!-- Wishlist Button -->
        <button 
            wire:click="toggleWishlist"
            class="text-red-400 hover:text-red-500 transition duration-300"
            :class="{ 'text-red-500': isInWishlist }"
            wire:loading.attr="disabled"
        >
            <svg class="w-5 h-5" 
                fill="{{ $isInWishlist ? 'currentColor' : 'none' }}" 
                stroke="currentColor" 
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
        </button>
        </div> 
        
        <!-- Price and Rating -->
        <div class="mt-3">
            <div class="flex items-center">
                @if($product->compare_price && $product->compare_price > $product->price)
                    <span class="text-gray-500 line-through mr-2">${{ number_format($product->compare_price, 2) }}</span>
                @endif
                <span class="font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
            </div>
            
            <div class="flex items-center mt-1">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= floor($product->rating))
                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    @elseif($i == ceil($product->rating) && $product->rating != floor($product->rating))
                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    @else
                        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    @endif
                @endfor
                <span class="text-xs text-gray-500 ml-1">({{ $product->rating }})</span>
            </div>
        </div>
        
        <!-- Add to Cart Button -->
        @if($showAddToCart)
            <button wire:click="addToCart" class="mt-4 w-full bg-primary-600 hover:bg-primary-700 text-white py-2 px-4 rounded-md transition duration-300 flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Add to Cart
            </button>
        @endif
    </div>
</div> 