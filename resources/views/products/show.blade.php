<!-- C:\laragon\www\laravel-ecommerce\resources\views\products\show.blade.php -->
@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Main Product Detail -->
        <livewire:product-card
            :product="$product"
            viewType="detail"
            :key="'product-detail-'.$product->id"
        />
        
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