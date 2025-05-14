<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl">
            <!-- Wishlist Header -->
            <div class="bg-indigo-600 px-6 py-4">
                <div class="flex items-center">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    <h1 class="ml-2 text-2xl font-bold text-white">My Wishlist</h1>
                </div>
            </div>
            
            <!-- Wishlist Content -->
            <div class="p-6 md:p-8">
                @if($wishlistItems->isEmpty())
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900">Your wishlist is empty</h3>
                        <p class="mt-1 text-gray-500">Start adding products to your wishlist!</p>
                        <div class="mt-6">
                            <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                                Browse Products
                            </a>
                        </div>
                    </div>
                @else
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($wishlistItems as $item)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow duration-300">
                                <div class="relative">
                                    <a href="{{ route('products.show', $item->product) }}">
                                        <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-48 object-cover">
                                    </a>
                                    <button 
                                        wire:click="removeFromWishlist({{ $item->product->id }})"
                                        class="absolute top-2 right-2 bg-white p-2 rounded-full shadow-md hover:bg-red-50 hover:text-red-500 transition-colors duration-200"
                                        title="Remove from wishlist"
                                    >
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="p-4">
                                    <h3 class="text-lg font-medium text-gray-900 mb-1">
                                        <a href="{{ route('products.show', $item->product) }}" class="hover:text-indigo-600 transition-colors duration-200">
                                            {{ $item->product->name }}
                                        </a>
                                    </h3>
                                    <div class="flex items-center justify-between mt-2">
                                        <span class="text-lg font-bold text-gray-900">${{ number_format($item->product->price, 2) }}</span>
                                        <button 
                                            wire:click="addToCartFromWishlist({{ $item->product->id }})"
                                            class="text-sm bg-indigo-600 hover:bg-indigo-700 text-white py-1 px-3 rounded-md transition-colors duration-200 flex items-center"
                                        >
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            Add to Cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $wishlistItems->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>