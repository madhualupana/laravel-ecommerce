<nav class="bg-white shadow-lg">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center">
                    <svg class="h-8 w-8 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span class="ml-2 text-xl font-bold text-gray-800">Infinity Spark</span>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="text-gray-800 hover:text-primary-600 font-medium">Home</a>
                <a href="{{ route('products.index') }}" class="text-gray-800 hover:text-primary-600 font-medium">Shop</a>
                
                <!-- Categories Dropdown -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="text-gray-800 hover:text-primary-600 font-medium flex items-center">
                        Categories
                        <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    
                    <div x-show="open" @click.away="open = false" 
                         class="absolute z-10 mt-2 w-48 bg-white rounded-md shadow-lg py-1">
                        @foreach($categories as $category)
                            <a href="{{ route('categories.show', $category) }}" 
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Search, Cart, Auth -->
            <div class="flex items-center space-x-4">
                <!-- Search -->
                <div class="relative hidden md:block">
                    <input wire:model.debounce.500ms="search" type="text" placeholder="Search products..." 
                           class="w-64 px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    
                    @if(strlen($search) >= 2)
                        <div class="absolute z-10 mt-1 w-full bg-white rounded-md shadow-lg">
                            @livewire('search-results', ['search' => $search], key($search))
                        </div>
                    @endif
                </div>

                <!-- Mobile Search Toggle -->
                <button class="md:hidden text-gray-600 hover:text-primary-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>

                <!-- Cart -->
                <a href="{{ route('cart.index') }}" class="relative text-gray-600 hover:text-primary-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    @if($cartCount > 0)
                        <span class="absolute -top-2 -right-2 bg-primary-600 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                <!-- Auth Links -->
                @auth
                    <a href="{{ route('profile') }}" class="text-gray-600 hover:text-primary-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-primary-600">Login</a>
                    <a href="{{ route('register') }}" class="text-gray-600 hover:text-primary-600">Register</a>
                @endauth

                <!-- Mobile Menu Toggle -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-gray-600 hover:text-primary-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false" class="md:hidden pb-4">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-800 hover:text-primary-600 hover:bg-gray-50">Home</a>
                <a href="{{ route('products.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-800 hover:text-primary-600 hover:bg-gray-50">Shop</a>
                
                <!-- Mobile Categories Dropdown -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="w-full flex justify-between items-center px-3 py-2 rounded-md text-base font-medium text-gray-800 hover:text-primary-600 hover:bg-gray-50">
                        Categories
                        <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    
                    <div x-show="open" class="pl-4">
                        @foreach($categories as $category)
                            <a href="{{ route('categories.show', $category) }}" 
                               class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-primary-600 hover:bg-gray-50">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>