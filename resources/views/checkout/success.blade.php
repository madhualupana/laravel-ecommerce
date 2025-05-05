<!-- resources\views\checkout\success.blade.php -->
@extends('layouts.app')

@section('title', 'Order Confirmation')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-md overflow-hidden p-8 text-center">
            <div class="mb-6">
                <svg class="mx-auto h-16 w-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Order Confirmed!</h1>
            <p class="text-lg text-gray-600 mb-6">Thank you for your purchase. Your order has been received.</p>
            
            <div class="bg-gray-50 rounded-lg p-6 mb-8 text-left">
                <h2 class="text-xl font-semibold mb-4 border-b pb-2">Order Details</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <p class="text-sm text-gray-500">Order Number</p>
                        <p class="font-medium">{{ $order->id }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Date</p>
                        <p class="font-medium">{{ $order->created_at->format('F j, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total</p>
                        <p class="font-medium">${{ number_format($order->total, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Payment Method</p>
                        <p class="font-medium">
                            @if($order->payment_method === 'cod')
                                Cash on Delivery
                            @elseif($order->payment_method === 'stripe')
                                Credit/Debit Card
                            @else
                                PayPal
                            @endif
                        </p>
                    </div>
                </div>
                
                <div class="border-t border-gray-200 pt-4">
                    <h3 class="text-lg font-medium mb-2">Shipping Address</h3>
                    <p class="text-gray-700">{{ $order->name }}</p>
                    <p class="text-gray-700">{{ $order->address }}</p>
                    <p class="text-gray-700">{{ $order->city }}, {{ $order->zip }}</p>
                </div>
            </div>
            
            <div class="space-y-4">
                <p class="text-gray-600">We've sent a confirmation email to {{ auth()->user()->email }}</p>
                
                <div class="flex flex-col sm:flex-row justify-center gap-4 mt-6">
                    <a href="{{ route('orders.show', $order->id) }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        View Order Details
                    </a>
                    <a href="{{ route('products.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection