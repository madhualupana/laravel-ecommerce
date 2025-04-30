<footer class="bg-gray-800 text-white py-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- About -->
            <div>
                <h3 class="text-lg font-semibold mb-4">About Us</h3>
                <p class="text-gray-400">LaravelShop is your one-stop destination for all your shopping needs. We offer quality products at competitive prices.</p>
            </div>
            
            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white">Home</a></li>
                    <li><a href="{{ route('products.index') }}" class="text-gray-400 hover:text-white">Shop</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">About Us</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Contact</a></li>
                </ul>
            </div>
            
            <!-- Categories -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Categories</h3>
                <ul class="space-y-2">
                    @foreach($categories as $category)
                        <li>
                            <a href="{{ route('categories.show', $category) }}" class="text-gray-400 hover:text-white">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            
            <!-- Contact -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Contact Us</h3>
                <address class="text-gray-400 not-italic">
                    <p>123 Shopping Street</p>
                    <p>E-Commerce City, EC 12345</p>
                    <p>Email: info@laravelshop.com</p>
                    <p>Phone: (123) 456-7890</p>
                </address>
            </div>
        </div>
        
        <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
            <p>&copy; {{ date('Y') }} LaravelShop. All rights reserved.</p>
        </div>
    </div>
</footer>