<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function show()
    {
        if (\Cart::count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        return view('checkout');
    }

    public function process(Request $request)
    {

        dd($request);
        // Add your checkout logic here
        // Process payment, create order, etc.
        
        return redirect()->route('checkout.success')->with('success', 'Order placed successfully!');
    }

    public function success()
    {
        if (!session()->has('success')) {
            return redirect()->route('home');
        }

        return view('checkout.success');
    }
}