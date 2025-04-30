@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">My Orders</h1>
    
    @if($orders->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <p class="text-gray-600">You haven't placed any orders yet.</p>
            <a href="{{ route('home') }}" class="mt-4 inline-block px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded">
                Start Shopping
            </a>
        </div>
    @else
        <div class="space-y-6">
            @foreach($orders as $order)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                        <div>
                            <h2 class="font-semibold">Order #{{ $order->id }}</h2>
                            <p class="text-sm text-gray-600">Placed on {{ $order->created_at->format('M d, Y') }}</p>
                        </div>
                        <span class="px-3 py-1 bg-gray-100 rounded-full text-sm font-medium">
                            {{ $order->status }}
                        </span>
                    </div>
                    <div class="p-4">
                        <!-- Order items would go here -->
                        <a href="{{ route('orders.show', $order) }}" class="text-primary-600 hover:text-primary-800">
                            View Order Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection