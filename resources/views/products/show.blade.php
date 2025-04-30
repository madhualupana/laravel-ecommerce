@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumbs -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary-600">
                        <svg class="w-3 h-3 mr-2.5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('categories.show', $product->category) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-primary-600 md:ml-2">{{ $product->category->name }}</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $product->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Product Details -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="md:flex">
                <!-- Product Images -->
                <div class="md:w-1/2 p-4">
                    <div class="mb-4"> 
                        <img id="mainImage" src="{{ asset('/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-96 object-contain rounded-lg">
                    </div>
                    <div class="grid grid-cols-4 gap-2">
                        <button onclick="changeImage('{{ asset('/' . $product->image) }}')" class="border-2 border-primary-500 rounded-lg overflow-hidden">
                            <img src="{{ asset('/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-20 object-cover">
                        </button>
                        @if($product->gallery)
                            @foreach($product->gallery as $image)
                                <button onclick="changeImage('{{ asset('/' . $image) }}')" class="border rounded-lg overflow-hidden hover:border-primary-500">
                                    <img src="{{ asset('/' . $image) }}" alt="{{ $product->name }}" class="w-full h-20 object-cover">
                                </button>
                            @endforeach   
                        @endif
                    </div>
                </div>
                
                <!-- Product Info -->
                <div class="md:w-1/2 p-6">
                    <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $product->name }}</h1>
                    
                    <div class="flex items-center mb-4">
                        <div class="flex items-center">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($product->rating))
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @elseif($i == ceil($product->rating) && $product->rating != floor($product->rating))
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endif
                            @endfor
                            <span class="text-gray-600 ml-2">({{ $product->rating }})</span>
                        </div>
                        <span class="mx-2 text-gray-400">|</span>
                        <span class="text-green-600 font-medium">In Stock</span>
                    </div>
                    
                    <div class="mb-6">
                        @if($product->compare_price && $product->compare_price > $product->price)
                            <div class="flex items-center">
                                <span class="text-3xl font-bold text-gray-800">${{ number_format($product->price, 2) }}</span>
                                <span class="ml-2 text-xl text-gray-500 line-through">${{ number_format($product->compare_price, 2) }}</span>
                                <span class="ml-2 bg-red-100 text-red-800 text-sm font-medium px-2 py-0.5 rounded">
                                    Save {{ $product->discount_percentage }}%
                                </span>
                            </div>
                        @else
                            <span class="text-3xl font-bold text-gray-800">${{ number_format($product->price, 2) }}</span>
                        @endif
                    </div>
                    
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Short Description</h3>
                        <p class="text-gray-600">{{ $product->short_description }}</p>
                    </div>
                    
                    <div class="flex items-center mb-6">
                        <div class="mr-4">
                            <span class="text-gray-600">Quantity</span>
                            <div class="flex items-center border rounded-md mt-1">
                                <button class="px-3 py-1 text-gray-600 hover:bg-gray-100" onclick="decreaseQuantity()">-</button>
                                <input type="number" id="quantity" value="1" min="1" max="10" class="w-12 text-center border-0 focus:ring-0">
                                <button class="px-3 py-1 text-gray-600 hover:bg-gray-100" onclick="increaseQuantity()">+</button>
                            </div>
                        </div>
                        <button wire:click="addToCart" class="flex-1 bg-primary-600 hover:bg-primary-700 text-white py-3 px-6 rounded-md transition duration-300 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Add to Cart
                        </button>
                    </div> 
                    
                    <div class="flex space-x-4 mb-6">
                        <button class="flex items-center text-gray-600 hover:text-primary-600">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            Wishlist
                        </button>
                        <button class="flex items-center text-gray-600 hover:text-primary-600">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                            Ask Question
                        </button>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-4">
                        <h3 class="text-sm font-medium text-gray-900">Delivery Options</h3>
                        <div class="mt-2">
                            <div class="flex items-center text-sm text-gray-700">
                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Free shipping on orders over $50
                            </div>
                            <div class="flex items-center text-sm text-gray-700 mt-1">
                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Delivery within 2-3 business days
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Product Tabs -->
            <div class="border-t border-gray-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex space-x-8">
                            <button id="description-tab" class="border-b-2 border-primary-500 py-4 px-1 text-sm font-medium text-primary-600">
                                Description
                            </button>
                            <button id="specifications-tab" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                Specifications
                            </button>
                            <button id="reviews-tab" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                Reviews
                            </button>
                        </nav>
                    </div>
                </div>
                
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                    <div id="description-content" class="prose max-w-none">
                        {!! $product->description !!}
                    </div>
                    
                    <div id="specifications-content" class="hidden">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium text-gray-900 mb-2">General</h4>
                                <ul class="space-y-2">
                                    <li class="flex justify-between">
                                        <span class="text-gray-600">Brand</span>
                                        <span class="text-gray-900">LaravelShop</span>
                                    </li>
                                    <li class="flex justify-between">
                                        <span class="text-gray-600">Model</span>
                                        <span class="text-gray-900">LS-{{ $product->id }}</span>
                                    </li>
                                    <li class="flex justify-between">
                                        <span class="text-gray-600">Category</span>
                                        <span class="text-gray-900">{{ $product->category->name }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium text-gray-900 mb-2">Dimensions</h4>
                                <ul class="space-y-2">
                                    <li class="flex justify-between">
                                        <span class="text-gray-600">Weight</span>
                                        <span class="text-gray-900">1.5 kg</span>
                                    </li>
                                    <li class="flex justify-between">
                                        <span class="text-gray-600">Dimensions</span>
                                        <span class="text-gray-900">20 × 15 × 10 cm</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div id="reviews-content" class="hidden">
                        <div class="space-y-6">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex items-center mb-2">
                                    <div class="flex items-center mr-4">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-5 h-5 {{ $i <= 4 ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="text-sm text-gray-500">2 days ago</span>
                                </div>
                                <h4 class="font-medium text-gray-900 mb-1">Great product!</h4>
                                <p class="text-gray-600">This product exceeded my expectations. The quality is excellent and it arrived quickly.</p>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex items-center mb-2">
                                    <div class="flex items-center mr-4">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-5 h-5 {{ $i <= 5 ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="text-sm text-gray-500">1 week ago</span>
                                </div>
                                <h4 class="font-medium text-gray-900 mb-1">Perfect!</h4>
                                <p class="text-gray-600">Exactly what I was looking for. Highly recommend!</p>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Write a review</h3>
                                <form>
                                    <div class="mb-4">
                                        <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <button type="button" class="text-gray-300 hover:text-yellow-400 focus:outline-none">
                                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                    </svg>
                                                </button>
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="review-title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                                        <input type="text" id="review-title" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                                    </div>
                                    <div class="mb-4">
                                        <label for="review-comment" class="block text-sm font-medium text-gray-700 mb-1">Comment</label>
                                        <textarea id="review-comment" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"></textarea>
                                    </div>
                                    <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white py-2 px-4 rounded-md transition duration-300">
                                        Submit Review
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Related Products -->
        <div class="mt-12">
            <h2 class="text-2xl font-bold mb-6">You may also like</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $product)
                @livewire('product-card', [
    'product' => $product,
    'showAddToCart' => true
], key('product-' . $product->id))
                @endforeach
            </div>
        </div>
    </div>

    <script>
        // Change product image
        function changeImage(src) {
            document.getElementById('mainImage').src = src;
        }
        
        // Quantity controls
        function increaseQuantity() {
            const quantityInput = document.getElementById('quantity');
            let quantity = parseInt(quantityInput.value);
            if (quantity < 10) {
                quantityInput.value = quantity + 1;
            }
        }
        
        function decreaseQuantity() {
            const quantityInput = document.getElementById('quantity');
            let quantity = parseInt(quantityInput.value);
            if (quantity > 1) {
                quantityInput.value = quantity - 1;
            }
        }
        
        // Tab switching
        const tabs = {
            'description-tab': 'description-content',
            'specifications-tab': 'specifications-content',
            'reviews-tab': 'reviews-content'
        };
        
        Object.entries(tabs).forEach(([tabId, contentId]) => {
            const tab = document.getElementById(tabId);
            const content = document.getElementById(contentId);
            
            tab.addEventListener('click', () => {
                // Hide all content
                Object.values(tabs).forEach(id => {
                    document.getElementById(id).classList.add('hidden');
                });
                
                // Remove active styles from all tabs
                Object.keys(tabs).forEach(id => {
                    document.getElementById(id).classList.remove('border-primary-500', 'text-primary-600');
                    document.getElementById(id).classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
                });
                
                // Show selected content
                content.classList.remove('hidden');
                
                // Style active tab
                tab.classList.add('border-primary-500', 'text-primary-600');
                tab.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
            });
        });
    </script>
@endsection