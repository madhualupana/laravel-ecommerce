<!-- cart.blade.php -->
<div>
    @if(count($cartContent) > 0)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Cart Header -->
            <div class="hidden md:flex bg-gray-50 px-6 py-3 border-b border-gray-200">
                <div class="w-2/5 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Product</div>
                <div class="w-1/5 text-center text-sm font-medium text-gray-500 uppercase tracking-wider">Price</div>
                <div class="w-1/5 text-center text-sm font-medium text-gray-500 uppercase tracking-wider">Quantity</div>
                <div class="w-1/5 text-center text-sm font-medium text-gray-500 uppercase tracking-wider">Total</div>
                <div class="w-1/5 text-right text-sm font-medium text-gray-500 uppercase tracking-wider">Remove</div>
            </div>

            <!-- Cart Items -->
<!-- Cart Items -->
<ul class="divide-y divide-gray-200">
    @foreach($cartContent as $item)

        <li class="p-4 flex flex-col md:flex-row items-start md:items-center" wire:key="cart-item-{{ $item['rowId'] }}">

            <!-- Product Info -->
            <div class="w-full md:w-2/5 flex items-start mb-4 md:mb-0">
                <div class="flex-shrink-0">
                    <!-- Check if the 'image' key exists -->
                    @if(isset($item['options']['image']))
                        <img src="{{ asset($item['options']['image']) }}" alt="{{ $item['name'] }}" class="w-20 h-20 object-cover rounded">
                    @else
                        <!-- Default image if 'image' key is not available -->
                        <img src="{{ asset('default-image.jpg') }}" alt="{{ $item['name'] }}" class="w-20 h-20 object-cover rounded">
                    @endif
                </div>
                <div class="ml-4">
                    <!-- Check if 'slug' key exists before trying to access it -->
                    @if(isset($item['options']['slug']))
                        <a href="{{ route('products.show', $item['options']['slug']) }}" class="font-medium text-gray-900 hover:text-primary-600">
                            {{ $item['name'] }}
                        </a>
                    @else
                        <!-- Fallback in case slug is not available -->
                        <span class="font-medium text-gray-900">{{ $item['name'] }}</span>
                    @endif

                    <!-- Check for color and size options -->
                    @if(isset($item['options']['color']) || isset($item['options']['size']))
                        <div class="mt-1 text-sm text-gray-500">
                            @if(!empty($item['options']['color']))
                                <span>Color: {{ $item['options']['color'] }}</span>
                            @endif
                            @if(!empty($item['options']['size']))
                                <span class="{{ !empty($item['options']['color']) ? 'ml-2' : '' }}">Size: {{ $item['options']['size'] }}</span>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Price -->
            <div class="w-1/2 md:w-1/5 text-left md:text-center mb-2 md:mb-0">
                <span class="md:hidden text-gray-500">Price: </span>
                ${{ number_format($item['price'], 2) }}
            </div>

            <!-- Quantity -->
            <div class="w-1/2 md:w-1/5 mb-4 md:mb-0">
                <div class="flex items-center max-w-xs mx-auto">
                    <button wire:click="decreaseQuantity('{{ $item['rowId'] }}')" 
                            class="px-2 py-1 border rounded-l-md text-gray-600 hover:bg-gray-100"
                            {{ $item['qty'] <= 1 ? 'disabled' : '' }}>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                        </svg>
                    </button>
                    <input type="number" 
                           wire:change="updateQuantity('{{ $item['rowId'] }}', $event.target.value)"
                           value="{{ $item['qty'] }}" 
                           min="1"
                           class="w-12 text-center border-t border-b border-gray-300 py-1">
                    <button wire:click="increaseQuantity('{{ $item['rowId'] }}')" 
                            class="px-2 py-1 border rounded-r-md text-gray-600 hover:bg-gray-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Total -->
            <div class="w-1/2 md:w-1/5 text-left md:text-center mb-2 md:mb-0">
                <span class="md:hidden text-gray-500">Total: </span>
                ${{ number_format($item['price'] * $item['qty'], 2) }}
            </div>

            <!-- Remove -->
            <div class="w-1/2 md:w-1/5 text-right">
            <button 
                wire:click="removeFromCart('{{ $item['rowId'] }}')" 
                wire:loading.attr="disabled"
                wire:target="removeFromCart"
                class="text-red-500 hover:text-red-700"
                title="Remove item"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>

            </div>
        </li>
    @endforeach
</ul>


            <!-- Cart Summary -->
            <div class="border-t border-gray-200 p-6 bg-gray-50">
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Subtotal</span>
                    <span class="font-medium">${{ number_format((float) str_replace(',', '', Cart::subtotal()), 2) }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Shipping</span>
                    <span class="font-medium">$0.00</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Tax</span>
                    <span class="font-medium">${{ number_format((float) str_replace(',', '', Cart::tax()), 2) }}</span>
                </div>
                <div class="flex justify-between text-lg font-bold mt-4 pt-4 border-t border-gray-200">
                    <span>Total</span>
                    <span>${{ number_format((float) str_replace(',', '', Cart::total()), 2) }}</span>
                </div>

                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('products.index') }}" 
                       class="bg-white border border-primary-600 text-primary-600 hover:bg-gray-50 py-3 px-6 rounded-md transition duration-300 flex items-center justify-center">
                        Continue Shopping
                    </a>
                    <a href="{{ route('checkout') }}" 
                       class="bg-primary-600 hover:bg-primary-700 text-white py-3 px-6 rounded-md transition duration-300 flex items-center justify-center">
                        Proceed to Checkout
                    </a>
                </div>

                @if(session()->has('coupon'))
                    <div class="mt-4 p-3 bg-green-50 rounded-md">
                        <div class="flex justify-between items-center">
                            <span class="text-green-700">Coupon Applied: {{ session('coupon')['name'] }}</span>
                            <button wire:click="removeCoupon" class="text-green-700 hover:text-green-900">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="text-right text-green-700">
                            -${{ number_format(session('coupon')['discount'], 2) }}
                        </div>
                    </div>
                @else
                    <div class="mt-4">
                        <div class="flex">
                            <input wire:model="couponCode" type="text" placeholder="Coupon code" 
                                   class="flex-1 border rounded-l-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-primary-500">
                            <button wire:click="applyCoupon" 
                                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-r-md transition duration-300">
                                Apply
                            </button>
                        </div>
                        @error('couponCode') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">Your shopping cart is empty</h3>
            <p class="mt-2 text-gray-500">You have no items in your shopping cart.</p>
            <div class="mt-6">
                <a href="{{ route('products.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Continue Shopping
                </a>
            </div>
        </div>
    @endif
</div>
