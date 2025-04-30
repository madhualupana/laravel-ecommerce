<ul>
    @forelse($results as $product)
        <li class="px-4 py-2 hover:bg-gray-100">
            <a href="{{ route('products.show', $product) }}" class="flex items-center">
                <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-10 h-10 object-cover mr-3">
                <div>
                    <div class="font-medium">{{ $product->name }}</div>
                    <div class="text-sm text-gray-600">${{ number_format($product->price, 2) }}</div>
                </div>
            </a>
        </li>
    @empty
        <li class="px-4 py-2 text-gray-500">No results found</li>
    @endforelse
    
    @if($results->count() > 0)
        <li class="px-4 py-2 border-t border-gray-200">
            <a href="{{ route('products.index', ['search' => $search]) }}" class="text-primary-600 font-medium">
                View all results
            </a>
        </li>
    @endif
</ul>