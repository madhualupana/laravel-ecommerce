@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Checkout</h1>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Order Summary -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
                
                @livewire('CartComponent') <!-- Reuse your cart component -->
                
                <div class="mt-6 border-t border-gray-200 pt-4">
                    <h3 class="text-lg font-medium mb-2">Payment Method</h3>
                    <div class="space-y-3">
                    <div class="flex items-center">
                            <input id="cod" name="payment" type="radio" checked class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300">
                            <label for="cod" class="ml-3 block text-sm font-medium text-gray-700">Cash on Delivery</label>
                        </div>
                        <div class="flex items-center">
                            <input id="paypal" name="payment" type="radio" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300">
                            <label for="paypal" class="ml-3 block text-sm font-medium text-gray-700">PayPal</label>
                        </div>

                        <div class="flex items-center">
                            <input id="stripe" name="payment" type="radio" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300">
                            <label for="stripe" class="ml-3 block text-sm font-medium text-gray-700">Stripe</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Checkout Form -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Shipping Information</h2>
                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" id="name" name="name" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                            <input type="text" id="address" name="address" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                <input type="text" id="city" name="city" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                            </div>
                            <div>
                                <label for="zip" class="block text-sm font-medium text-gray-700">ZIP Code</label>
                                <input type="text" id="zip" name="zip" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                            </div>
                        </div>
                        
                        <div>
                            <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white py-3 px-4 rounded-md shadow-sm text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Complete Order (${{ number_format((float) preg_replace('/[^\d.]/', '', \Cart::total()), 2) }})
                            </button>
                        </div>
                    </div>
                </form> 
            </div>
        </div>
    </div>
</div>
@endsection