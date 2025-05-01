<div>
    <ul>
        @forelse($results as $product)
            <li>
                <a href="{{ route('products.show', $product) }}" 
                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                    <div class="flex items-center">
                        @if($product->image)
                            <img src="{{ asset($product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="h-8 w-8 rounded-full mr-3">
                        @endif
                        <div>
                            <div>{{ $product->name }}</div>
                            <div class="text-xs text-gray-500">${{ number_format($product->price, 2) }}</div>
                        </div>
                    </div>
                </a>
            </li>
        @empty
            @if(strlen($search) >= 2)
                <li class="px-4 py-2 text-sm text-gray-700">No results found for "{{ $search }}"</li>
            @endif
        @endforelse
    </ul>
</div>