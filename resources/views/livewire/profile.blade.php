<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl">
            <!-- Profile Header -->
            <div class="bg-indigo-600 px-6 py-4">
                <div class="flex items-center">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <h1 class="ml-2 text-2xl font-bold text-white">My Profile</h1>
                </div>
            </div>
            
            <!-- Profile Content -->
            <div class="p-6 md:p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Personal Information -->
                    <div class="space-y-6">
                        <h2 class="text-xl font-semibold text-gray-800 border-b pb-2 flex items-center">
                            <svg class="h-5 w-5 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Personal Information
                        </h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Full Name</label>
                                <p class="mt-1 text-lg font-medium text-gray-900">{{ $user->name }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Email Address</label>
                                <p class="mt-1 text-lg font-medium text-gray-900">{{ $user->email }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Account Actions -->
                    <div class="space-y-6">
                        <h2 class="text-xl font-semibold text-gray-800 border-b pb-2 flex items-center">
                            <svg class="h-5 w-5 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Account Actions
                        </h2>
                        
                        <div class="space-y-4">
                            <a href="{{ route('password.request') }}" class="group flex items-center px-4 py-3 bg-gray-50 hover:bg-indigo-50 rounded-lg transition-colors duration-200">
                                <svg class="h-6 w-6 text-gray-400 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <span class="ml-3 text-gray-700 group-hover:text-indigo-600 font-medium">Change Password</span>
                            </a>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full group flex items-center px-4 py-3 bg-gray-50 hover:bg-red-50 rounded-lg transition-colors duration-200">
                                    <svg class="h-6 w-6 text-gray-400 group-hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    <span class="ml-3 text-gray-700 group-hover:text-red-600 font-medium">Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Orders Section -->
                <div class="mt-12">
                    <h2 class="text-xl font-semibold text-gray-800 border-b pb-2 flex items-center">
                        <svg class="h-5 w-5 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        My Orders
                    </h2>

                    <!-- Status Filter Tabs -->
                    <div class="flex overflow-x-auto mt-4 mb-6 pb-2 -mx-2">
                        <button wire:click="$set('status', 'all')" 
                           class="px-4 py-2 mx-2 rounded-full text-sm font-medium whitespace-nowrap 
                                  {{ $status === 'all' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            All Orders
                        </button>
                        <button wire:click="$set('status', 'completed')" 
                           class="px-4 py-2 mx-2 rounded-full text-sm font-medium whitespace-nowrap 
                                  {{ $status === 'completed' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Completed
                        </button>
                        <button wire:click="$set('status', 'pending')" 
                           class="px-4 py-2 mx-2 rounded-full text-sm font-medium whitespace-nowrap 
                                  {{ $status === 'pending' ? 'bg-yellow-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Pending
                        </button>
                        <button wire:click="$set('status', 'processing')" 
                           class="px-4 py-2 mx-2 rounded-full text-sm font-medium whitespace-nowrap 
                                  {{ $status === 'processing' ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Processing
                        </button>
                        <button wire:click="$set('status', 'cancelled')" 
                           class="px-4 py-2 mx-2 rounded-full text-sm font-medium whitespace-nowrap 
                                  {{ $status === 'cancelled' ? 'bg-red-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Cancelled
                        </button>
                    </div>

                    <!-- Orders List -->
                    @if($orders->isEmpty())
                        <div class="bg-gray-50 rounded-lg p-6 text-center">
                            <svg class="h-12 w-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <h3 class="mt-2 text-lg font-medium text-gray-900">No orders found</h3>
                            <p class="mt-1 text-gray-500">You don't have any orders matching this status.</p>
                            <a href="{{ route('home') }}" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                                Continue Shopping
                            </a>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($orders as $order)
                                <div class="bg-gray-50 rounded-lg overflow-hidden border border-gray-200 hover:border-indigo-300 transition-colors duration-200">
                                    <div class="p-4 sm:p-6">
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                            <div class="mb-4 sm:mb-0">
                                                <h3 class="text-lg font-medium text-gray-900">
                                                    Order #{{ $order->id }}
                                                </h3>
                                                <p class="text-sm text-gray-500 mt-1">
                                                    Placed on {{ $order->created_at->format('M d, Y \a\t h:i A') }}
                                                </p>
                                            </div>
                                            <div class="flex items-center">
                                                <span class="px-3 py-1 rounded-full text-sm font-medium 
                                                    @if($order->status === 'completed') bg-green-100 text-green-800
                                                    @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                                    @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                                    @else bg-yellow-100 text-yellow-800 @endif">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                                <span class="ml-4 text-lg font-semibold text-gray-900">
                                                    ${{ number_format($order->total, 2) }}
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-4 border-t border-gray-200 pt-4">
                                            <h4 class="sr-only">Items</h4>
                                            <div class="space-y-4">
                                                @foreach($order->items as $item)
                                                    <div class="flex items-start">
                                                        <div class="flex-shrink-0 h-16 w-16 rounded-md overflow-hidden">
                                                            <img src="{{ asset($item->product->image) }}" 
                                                                 alt="{{ $item->product->name }}" 
                                                                 class="h-full w-full object-cover object-center">
                                                        </div>
                                                        <div class="ml-4 flex-1">
                                                            <div class="flex items-center justify-between text-base font-medium text-gray-900">
                                                                <h5>{{ $item->product->name }}</h5>
                                                                <p>${{ number_format($item->price, 2) }}</p>
                                                            </div>
                                                            <p class="mt-1 text-sm text-gray-500">
                                                                Qty: {{ $item->quantity }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        
                                        <div class="mt-6 flex justify-end">
                                            <a href="{{ route('orders.show', $order) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                                View order details
                                                <span aria-hidden="true"> &rarr;</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $orders->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>