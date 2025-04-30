@extends('layouts.app')

@section('title', 'Order Successful')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-8 text-center">
        <svg class="mx-auto h-16 w-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <h1 class="text-2xl font-bold mt-4 mb-2">Order Placed Successfully!</h1>
        <p class="text-gray-600 mb-6">{{ session('success') }}</p>
        <div class="flex justify-center space-x-4">
            <a href="{{ route('home') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded">
                Continue Shopping
            </a>
            <a href="{{ route('orders.index') }}" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded">
                View My Orders
            </a>
        </div>
    </div>
</div>
@endsection