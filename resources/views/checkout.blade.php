@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Checkout</h1>
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
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
                            <input checked id="cod" name="payment_method" type="radio" value="cod" 
                                   class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                            <label for="cod" class="ml-3 block text-sm font-medium text-gray-700">
                                <span class="flex items-center">
                                    <svg class="h-6 w-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Cash on Delivery
                                </span>
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input id="razorpay" name="payment_method" type="radio" value="razorpay" 
                                   class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                            <label for="razorpay" class="ml-3 block text-sm font-medium text-gray-700">
                                <span class="flex items-center">
                                    <svg class="h-6 w-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Razorpay
                                </span>
                            </label>
                        </div>
                        
                        <div class="flex items-center">
                            <input id="stripe" name="payment_method" type="radio" value="stripe" 
                                   class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                            <label for="stripe" class="ml-3 block text-sm font-medium text-gray-700">
                                <span class="flex items-center">
                                    <svg class="h-6 w-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                    Credit/Debit Card (Stripe)
                                </span>
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input id="paypal" name="payment_method" type="radio" value="paypal" 
                                   class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                            <label for="paypal" class="ml-3 block text-sm font-medium text-gray-700">
                                <span class="flex items-center">
                                    <svg class="h-6 w-6 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M10.13 17.959c-1.094.13-1.678.16-3.274.16H4.5V8.4h2.205c1.388 0 2.249.16 3.07.461.978.358 1.733 1.067 2.018 2.104.32 1.165.08 2.469-.588 3.258-.607.721-1.48 1.064-2.473 1.134l3.398.602zm-1.05-5.946c-.31-.244-.773-.366-1.294-.366H6.622v2.732h1.241c.521 0 .984-.153 1.295-.366.33-.229.484-.605.437-1.003-.033-.283-.17-.6-.437-.797-.12-.092-.24-.166-.367-.2z"/>
                                        <path d="M19.5 8.4h-2.204c-1.388 0-2.249.16-3.07.461-.978.358-1.733 1.067-2.018 2.104-.32 1.165-.08 2.469.588 3.258.607.721 1.48 1.064 2.473 1.134l-3.398.602c1.094.13 1.678.16 3.274.16h2.355V8.4zm-2.956 3.613c-.31-.244-.773-.366-1.294-.366h-1.172v2.732h1.241c.521 0 .984-.153 1.295-.366.33-.229.484-.605.437-1.003-.033-.283-.17-.6-.437-.797-.12-.092-.24-.166-.367-.2z"/>
                                    </svg>
                                    PayPal
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Checkout Form -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Shipping Information</h2>
                <form id="checkout-form" action="{{ route('checkout.process') }}" method="POST">
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
                        
                        <!-- Hidden payment method field -->
                        <input type="hidden" name="payment_method" id="payment_method" value="">
                        
                        <!-- Stripe Elements Container -->
                        <div id="stripe-element" class="hidden mt-4">
                            <div id="card-element" class="border border-gray-300 p-3 rounded-md"></div>
                            <div id="card-errors" role="alert" class="text-red-500 text-sm mt-2"></div>
                            <input type="hidden" name="payment_intent" id="payment_intent" value="">
                        </div>
                        
                        <button id="submit-btn" type="submit" 
                                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 px-4 rounded-md shadow-sm text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-300 mt-4">
                            Complete Order (${{ number_format((float) preg_replace('/[^\d.]/', '', Cart::total()), 2) }})
                        </button>
                    </div>
                </form> 
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <!-- Stripe JS -->
    <script src="https://js.stripe.com/v3/"></script>
    <!-- Razorpay JS -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    
    <script>
        const stripe = Stripe('{{ $stripeKey }}');
        const elements = stripe.elements();
        const cardElement = elements.create('card');
        
        // Initialize with first payment method selected
        const initialPaymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
        document.getElementById('payment_method').value = initialPaymentMethod;
        
        // Handle payment method selection
        document.querySelectorAll('input[name="payment_method"]').forEach(el => {
            el.addEventListener('change', function() {
                const selectedMethod = this.value;
                document.getElementById('payment_method').value = selectedMethod;
                
                if (selectedMethod === 'stripe') {
                    document.getElementById('stripe-element').classList.remove('hidden');
                    try {
                        cardElement.mount('#card-element');
                    } catch(e) {
                        console.error('Stripe element already mounted');
                    }
                } else {
                    document.getElementById('stripe-element').classList.add('hidden');
                    try {
                        cardElement.unmount();
                    } catch(e) {
                        console.error('Stripe element not mounted');
                    }
                }
            });
        });
        
        // Handle Razorpay payment
        async function handleRazorpayPayment(orderData) {
            const options = {
                "key": "{{ config('services.razorpay.key') }}",
                "amount": orderData.amount * 100, // Razorpay expects amount in paise
                "currency": "INR",
                "name": "{{ config('app.name') }}",
                "description": "Order Payment",
                "order_id": orderData.razorpay_order_id,
                "handler": function (response) {
                    // Submit form with Razorpay response
                    const form = document.getElementById('checkout-form');
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'razorpay_payment_id';
                    input.value = response.razorpay_payment_id;
                    form.appendChild(input);
                    
                    const orderInput = document.createElement('input');
                    orderInput.type = 'hidden';
                    orderInput.name = 'razorpay_order_id';
                    orderInput.value = orderData.razorpay_order_id;
                    form.appendChild(orderInput);
                    
                    const signatureInput = document.createElement('input');
                    signatureInput.type = 'hidden';
                    signatureInput.name = 'razorpay_signature';
                    signatureInput.value = response.razorpay_signature;
                    form.appendChild(signatureInput);
                    
                    form.submit();
                },
                "prefill": {
                    "name": document.getElementById('name').value,
                    "email": "{{ auth()->user() ? auth()->user()->email : '' }}",
                    "contact": "" // You can add phone field to your form
                },
                "notes": {
                    "address": document.getElementById('address').value
                },
                "theme": {
                    "color": "#F37254"
                }
            };
            
            const rzp = new Razorpay(options);
            rzp.open();
        }

        // Handle form submission
        const form = document.getElementById('checkout-form');
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const submitBtn = document.getElementById('submit-btn');
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Processing...';
            
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
            
            // Validate form
            const requiredFields = ['name', 'address', 'city', 'zip'];
            let isValid = true;
            
            requiredFields.forEach(field => {
                const element = document.getElementById(field);
                if (!element.value.trim()) {
                    element.classList.add('border-red-500');
                    isValid = false;
                } else {
                    element.classList.remove('border-red-500');
                }
            });
            
            if (!isValid) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
                return;
            }
            
            if (paymentMethod === 'razorpay') {
                try {
                    // Create order on your server first
                    const response = await fetch('{{ route("razorpay.order.create") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            amount: {{ (float) str_replace(['$', ','], '', Cart::total()) }},
                            currency: 'INR'
                        })
                    });
                    
                    const orderData = await response.json();
                    
                    if (orderData.error) {
                        throw new Error(orderData.error);
                    }
                    
                    // Handle Razorpay payment
                    await handleRazorpayPayment(orderData);
                    
                } catch (err) {
                    console.error('Razorpay error:', err);
                    alert('Payment processing failed: ' + err.message);
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                }
            } else if (paymentMethod === 'stripe') {
                try {
                    const {paymentIntent, error} = await stripe.confirmCardPayment(
                        '{{ $clientSecret }}', {
                            payment_method: {
                                card: cardElement,
                                billing_details: {
                                    name: document.getElementById('name').value,
                                    address: {
                                        line1: document.getElementById('address').value,
                                        city: document.getElementById('city').value,
                                        postal_code: document.getElementById('zip').value
                                    }
                                }
                            }
                        }
                    );
                    
                    if (error) {
                        document.getElementById('card-errors').textContent = error.message;
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnText;
                    } else {
                        document.getElementById('payment_intent').value = paymentIntent.id;
                        // Submit the form normally after Stripe confirmation
                        form.submit();
                    }
                } catch (err) {
                    console.error('Stripe error:', err);
                    document.getElementById('card-errors').textContent = 'Payment processing failed. Please try again.';
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                }
            } else {
                // For COD or PayPal, submit the form normally
                form.submit();
            }
        });
    </script>
@endpush
@endsection