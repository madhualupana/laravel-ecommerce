<!-- C:\laragon\www\laravel-ecommerce\resources\views\components\layouts\app.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Livewire Styles -->
    @livewireStyles
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
    @livewire('navigation')

        <!-- Page Content -->
        <main>
            {{ $slot }}
            
        </main>
        @livewire('footer')
    </div>

    @livewireScripts
    <div x-data="{ 
        show: false, 
        message: '', 
        productName: '', 
        productImage: '' 
    }" 
    x-show="show"
    @notify.window="
        show = true;
        message = $event.detail.message;
        productName = $event.detail.productName;
        productImage = $event.detail.productImage;
        setTimeout(() => show = false, 3000)
    "
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-4"
    x-transition:enter-end="opacity-100 translate-y-0"
    class="fixed bottom-4 right-4 z-50 w-80">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200">
        <div class="flex p-4">
        <img :src="productImage.startsWith('http') ? productImage : ('/storage/' + productImage)" 
     class="h-12 w-12 object-cover rounded" 
     :alt="productName">
            <div class="ml-3 flex-1">
                <p class="text-sm font-medium text-gray-900" x-text="message"></p>
                <p class="text-sm text-gray-500" x-text="productName"></p>
            </div>
            <button @click="show = false" class="text-gray-400 hover:text-gray-500">
                ✕
            </button>
        </div>
        <div class="bg-primary-600 h-1 w-full" 
             x-show="show" 
             x-transition.duration.3000ms></div>
    </div>
</div>

</body>
</html>