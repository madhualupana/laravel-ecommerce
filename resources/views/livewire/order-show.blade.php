<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl">
            <!-- Order Header -->
            <div class="bg-indigo-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <h1 class="ml-2 text-2xl font-bold text-white">Order #{{ $order->id }}</h1>
                    </div>
                    <span class="px-3 py-1 rounded-full text-sm font-medium 
                        @if($order->status === 'completed') bg-green-100 text-green-800
                        @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                        @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                        @else bg-yellow-100 text-yellow-800 @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>
            
            <!-- Order Content -->
            <div class="p-6 md:p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Order Items -->
                    <div class="md:col-span-2">
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h2 class="text-xl font-semibold text-gray-800 border-b pb-2 flex items-center">
                                <svg class="h-5 w-5 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                Order Items
                            </h2>
                            
                            <div class="mt-4 space-y-4">
                                @foreach($order->items as $item)
                                <div class="flex items-start p-3 bg-white rounded-lg shadow-sm hover:shadow transition-shadow duration-200">
                                    <div class="flex-shrink-0 h-16 w-16 rounded-md overflow-hidden border border-gray-200">
                                        <img src="{{ asset($item->product->image) }}" 
                                             alt="{{ $item->product->name }}" 
                                             class="h-full w-full object-cover object-center">
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <h4 class="text-base font-medium text-gray-900">{{ $item->product->name }}</h4>
                                                <p class="mt-1 text-sm text-gray-500">${{ number_format($item->price, 2) }} x {{ $item->quantity }}</p>
                                            </div>
                                            <p class="text-base font-medium text-gray-900">${{ number_format($item->price * $item->quantity, 2) }}</p>
                                        </div>
                                        @if($item->options)
                                        <div class="mt-2">
                                            <p class="text-xs text-gray-500">
                                                @foreach(json_decode($item->options, true) as $key => $value)
                                                    {{ ucfirst($key) }}: {{ $value }}@if(!$loop->last), @endif
                                                @endforeach
                                            </p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <!-- Order Summary -->
                    <div class="space-y-6">
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h2 class="text-xl font-semibold text-gray-800 border-b pb-2 flex items-center">
                                <svg class="h-5 w-5 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Order Summary
                            </h2>
                            
                            <div class="mt-4 space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Order Date</span>
                                    <span class="text-gray-900 font-medium">{{ $order->created_at->format('M d, Y \a\t h:i A') }}</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Payment Method</span>
                                    <span class="text-gray-900 font-medium">{{ strtoupper($order->payment_method) }}</span>
                                </div>
                                
                                @if($order->transaction_id)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Transaction ID</span>
                                    <span class="text-gray-900 font-medium">{{ $order->transaction_id }}</span>
                                </div>
                                @endif
                                
                                <div class="border-t border-gray-200 my-2"></div>
                                
                                <div class="flex justify-between text-lg font-bold">
                                    <span>Total Amount</span>
                                    <span>${{ number_format($order->total, 2) }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Shipping Address -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h2 class="text-xl font-semibold text-gray-800 border-b pb-2 flex items-center">
                                <svg class="h-5 w-5 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Shipping Address
                            </h2>
                            
                            <div class="mt-4 space-y-2 text-gray-700">
                                <p class="font-medium">{{ $order->name }}</p>
                                <p>{{ $order->address }}</p>
                                <p>{{ $order->city }}, {{ $order->zip }}</p>
                            </div>
                        </div>
                        
                        <!-- Back Button -->
                        <a href="{{ route('orders.index') }}" class="group flex items-center justify-center px-4 py-3 bg-gray-50 hover:bg-indigo-50 rounded-lg transition-colors duration-200">
                            <svg class="h-5 w-5 text-gray-400 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            <span class="ml-2 text-gray-700 group-hover:text-indigo-600 font-medium">Back to Orders</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>