<div>
    @if(Cart::count() > 0)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Cart Items -->
            <ul class="divide-y divide-gray-200">
                @foreach(Cart::content() as $item)
                    <li class="p-4 flex">
                        <div class="flex-shrink-0">
                            <img src="{{ $item->options->image }}" alt="{{ $item->name }}" class="w-20 h-20 object-cover rounded">
                        </div>
                        <div class="ml-4 flex-1">
                            <div class="flex justify-between">
                                <div>
                                    <a href="{{ route('products.show', $item->options->slug) }}" class="font-medium text-gray-900 hover:text-primary-600">{{ $item->name }}</a>
                                    <p class="mt-1 text-sm text-gray-500">${{ number_format($item->price, 2) }}</p>
                                </div>
                                <button wire:click="removeFromCart('{{ $item->rowId }}')" class="text-gray-400 hover:text-red-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                            <div class="flex justify-between items-center mt-2">
                                <div class="flex items-center border rounded-md">
                                    <button wire:click="updateQuantity('{{ $item->rowId }}', {{ $item->qty - 1 }})" class="px-2 py-1 text-gray-600 hover:bg-gray-100" {{ $item->qty <= 1 ? 'disabled' : '' }}>-</button>
                                    <span class="px-2">{{ $item->qty }}</span>
                                    <button wire:click="updateQuantity('{{ $item->rowId }}', {{ $item->qty + 1 }})" class="px-2 py-1 text-gray-600 hover:bg-gray-100">+</button>
                                </div>
                                <span class="font-medium">${{ number_format($item->price * $item->qty, 2) }}</span>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
            
            <!-- Cart Summary -->
            <div class="border-t border-gray-200 p-4">
                <div class="flex justify-between text-lg font-medium mb-4">
                    <span>Subtotal</span>
                    <span>${{ number_format((float) str_replace(',', '', Cart::subtotal()), 2) }}</span>
                </div>
                <div class="flex justify-between text-lg font-medium mb-4">
                    <span>Tax</span>
                    <span>${{ number_format((float) str_replace(',', '', Cart::tax()), 2) }}</span>
                </div>
                <div class="flex justify-between text-xl font-bold">
                    <span>Total</span>
                    <span>${{ number_format((float) str_replace(',', '', Cart::total()), 2) }}</span>
                </div>
                <div class="mt-6">
                    <a href="{{ route('checkout') }}" class="w-full bg-primary-600 hover:bg-primary-700 text-white py-3 px-6 rounded-md transition duration-300 flex items-center justify-center">
                        Proceed to Checkout
                    </a>
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('products.index') }}" class="text-primary-600 hover:text-primary-800 font-medium">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <h3 class="mt-2 text-lg font-medium text-gray-900">Your cart is empty</h3>
            <p class="mt-1 text-gray-500">Start adding some products to your cart.</p>
            <div class="mt-6">
                <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700">
                    Browse Products
                </a>
            </div>
        </div>
    @endif
</div>