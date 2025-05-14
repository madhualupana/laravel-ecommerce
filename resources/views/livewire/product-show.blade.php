<div class="container mx-auto px-4 py-8">
    <!-- Main Product Detail -->
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
                            <button
                            wire:click="changeImage('{{ $image }}')"
                            class="border rounded-lg overflow-hidden hover:border-primary-500 transition-colors"
                        >
                            <img 
                                src="{{ asset($image) }}" 
                                alt="{{ $product->name }}" 
                                class="w-full h-20 object-cover"
                                onerror="this.parentElement.remove()"
                            >
                        </button>
                            @endforeach   
                        @endif
                    </div>
                </div>




            <!-- Product Info -->
            <div class="md:w-1/2 p-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>
                
                <div class="flex items-center mb-4">
                    <div class="flex items-center">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $product->rating)
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            @else
                                <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            @endif
                        @endfor
                    </div>
                    <span class="text-gray-600 ml-2">({{ $product->reviews_count }} reviews)</span>
                </div>

                <div class="mb-6">
                    <span class="text-3xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                    @if($product->compare_at_price)
                        <span class="text-xl text-gray-500 line-through ml-2">${{ number_format($product->compare_at_price, 2) }}</span>
                        <span class="bg-red-100 text-red-800 text-sm font-medium ml-2 px-2.5 py-0.5 rounded">{{ round(($product->compare_at_price - $product->price) / $product->compare_at_price * 100) }}% off</span>
                    @endif
                </div>

                <p class="text-gray-700 mb-6">{{ $product->short_description }}</p>

                <!-- Quantity Selector -->
                <div class="flex items-center mb-6">
    <span class="mr-4 text-gray-700">Quantity:</span>
    <div class="flex items-center border border-gray-300 rounded-md">
        <button 
            wire:click="decreaseQuantity"
            class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-l-md"
            :disabled="quantity <= 1"
        >
            -
        </button>
        <span class="px-4 py-1 bg-white text-center w-12">{{ $quantity }}</span>
        <button 
            wire:click="increaseQuantity"
            class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-r-md"
            :disabled="quantity >= 10"
        >
            +
        </button>
    </div>
</div>

                <!-- Add to Cart Button -->
                <button 
                    wire:click="addToCart"
                    class="w-full bg-primary-600 hover:bg-primary-700 text-white font-bold py-3 px-4 rounded-md transition-colors mb-4"
                >
                    Add to Cart
                </button>

                <!-- Wishlist Button -->
                <button 
                    wire:click="toggleWishlist"
                    class="w-full border border-gray-300 hover:bg-gray-100 text-gray-700 font-bold py-3 px-4 rounded-md transition-colors flex items-center justify-center"
                    :class="{ 'bg-gray-100': isInWishlist }"
                >
                    <svg class="w-5 h-5 mr-2" 
                        fill="{{ $isInWishlist ? 'currentColor' : 'none' }}" 
                        stroke="currentColor" 
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    {{ $isInWishlist ? 'Remove from Wishlist' : 'Add to Wishlist' }}
                </button>
            </div>
        </div>

        <!-- Product Tabs -->
        <div class="border-t border-gray-200 px-6 py-4">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8">
                    <button
                        wire:click="switchTab('description')"
                        class="{{ $activeTab === 'description' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                    >
                        Description
                    </button>
                    <button
                        wire:click="switchTab('specifications')"
                        class="{{ $activeTab === 'specifications' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                    >
                        Specifications
                    </button>
                    <button
                        wire:click="switchTab('reviews')"
                        class="{{ $activeTab === 'reviews' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                    >
                        Reviews ({{ $product->reviews_count }})
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="py-4">
                <div class="{{ $activeTab !== 'description' ? 'hidden' : '' }}" id="description-content">
                    {!! $product->description !!}
                </div>

                <div class="{{ $activeTab !== 'specifications' ? 'hidden' : '' }}" id="specifications-content">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse($product->specifications ?? [] as $spec)
            <div class="border-b border-gray-100 py-2">
                <span class="font-medium text-gray-700">{{ $spec['name'] ?? 'Specification' }}:</span>
                <span class="text-gray-600 ml-2">{{ $spec['value'] ?? 'Not specified' }}</span>
            </div>
        @empty
            <div class="col-span-2 text-gray-500">
                No specifications available for this product.
            </div>
        @endforelse
    </div>
</div>

                <div class="{{ $activeTab !== 'reviews' ? 'hidden' : '' }}" id="reviews-content">
                    @if($product->reviews_count > 0)
                        <div class="space-y-6">
                            @foreach($product->reviews as $review)
                                <div class="border-b border-gray-200 pb-6">
                                    <div class="flex items-center mb-2">
                                        <div class="flex items-center mr-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                @else
                                                    <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="font-medium">{{ $review->user->name }}</span>
                                        <span class="text-gray-500 text-sm ml-2">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>
                                    <h4 class="font-medium mb-1">{{ $review->title }}</h4>
                                    <p class="text-gray-700">{{ $review->content }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No reviews yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Products -->
    <div class="mt-12">
        <h2 class="text-2xl font-bold mb-6">You may also like</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($relatedProducts as $product)
                <livewire:product-card
                    :product="$product" 
                    viewType="card"
                    :key="'related-product-'.$product->id"
                />
            @endforeach
        </div>
    </div>
</div>