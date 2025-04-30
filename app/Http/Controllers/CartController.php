<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('cart.index');
    }

    public function store(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        
        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => $request->quantity ?? 1,
            'price' => $product->price,
            'options' => [
                'image' => $product->image,
                'slug' => $product->slug,
            ]
        ]);

        return redirect()->route('cart.index')->with('success', 'Product added to cart successfully!');
    }

    public function update(Request $request, $rowId)
    {
        Cart::update($rowId, $request->quantity);
        
        return back()->with('success', 'Cart updated successfully');
    }

    public function destroy($rowId)
    {
        Cart::remove($rowId);
        
        return back()->with('success', 'Product removed from cart');
    }
}