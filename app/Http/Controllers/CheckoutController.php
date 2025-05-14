<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Cart;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Razorpay\Api\Api;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
 
class CheckoutController extends Controller
{
    public function show()
    {
        if (Cart::count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        $amount = (float) str_replace(['$', ','], '', Cart::total());
        
        // For Stripe integration
        Stripe::setApiKey(config('services.stripe.secret'));
        $intent = PaymentIntent::create([
            'amount' => round($amount * 100),
            'currency' => 'usd',
        ]);

        return view('checkout', [
            'clientSecret' => $intent->client_secret,
            'stripeKey' => config('services.stripe.key'),
            'paymentIntentId' => $intent->id
        ]);
    }

    public function createRazorpayOrder(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'currency' => 'required|string'
        ]);

        try {
            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
            
            $order = $api->order->create([
                'amount' => $request->amount * 100, // Convert to paise
                'currency' => $request->currency,
                'payment_capture' => 1 // Auto capture payment
            ]);

            return response()->json([
                'razorpay_order_id' => $order->id,
                'amount' => $request->amount,
                'currency' => $request->currency
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function process(Request $request)
    { 
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'zip' => 'required',
            'payment_method' => 'required'
        ]);

        $paymentMethod = $request->payment_method;

        try {
            // Create order record
            $order = Order::create([
                'user_id' => auth()->id(),
                'name' => $request->name,
                'address' => $request->address,
                'city' => $request->city,
                'zip' => $request->zip,
                'total' => (float) str_replace(['$', ','], '', Cart::total()),
                'payment_method' => $paymentMethod,
                'status' => $paymentMethod === 'cod' ? 'pending' : 'processing',
                'payment_status' => 'pending',
                'transaction_id' => $paymentMethod === 'stripe' ? $request->payment_intent : 
                                   ($paymentMethod === 'razorpay' ? $request->razorpay_payment_id : null)
            ]);

            // Add order items
            foreach (Cart::content() as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->id,
                    'price' => $item->price,
                    'quantity' => $item->qty,
                    'options' => json_encode($item->options)
                ]);
            }

            // Handle different payment methods
            switch ($paymentMethod) {
                case 'cod':
                    Cart::destroy();
                    return redirect()->route('checkout.success')->with('order', $order);

                case 'stripe':
                    $order->update(['status' => 'completed']);
                    Cart::destroy();
                    return redirect()->route('checkout.success')->with('order', $order);

                case 'razorpay':
                    // Verify the payment
                    $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
                    $order->update([
                        'transaction_id' => $request->razorpay_payment_id,
                        'razorpay_order_id' => $request->razorpay_order_id // Store this too
                    ]);
                    try {
                        $attributes = [
                            'razorpay_order_id' => $request->razorpay_order_id,
                            'razorpay_payment_id' => $request->razorpay_payment_id,
                            'razorpay_signature' => $request->razorpay_signature
                        ];
                        
                        $api->utility->verifyPaymentSignature($attributes);
                        
                        // Immediately mark as paid since we're doing auto-capture
                        $order->update([
                            'status' => 'completed',
                            'payment_status' => 'paid'
                        ]);
                        
                        Cart::destroy();
                        return redirect()->route('checkout.success')->with('order', $order);
                    } catch (\Exception $e) {
                        $order->update(['status' => 'failed']);
                        return back()->with('error', 'Payment verification failed: '.$e->getMessage());
                    }

                case 'paypal':
                    return $this->processPaypalPayment($order);
            }

        } catch (\Exception $e) {
            return back()->with('error', 'Error processing order: ' . $e->getMessage());
        }
    }

    protected function processPaypalPayment($order)
    {
        try {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('services.paypal'));
            
            // Verify credentials exist
            $config = config('services.paypal');
            if (empty($config['sandbox']['client_id']) || empty($config['sandbox']['client_secret'])) {
                throw new \Exception('PayPal sandbox credentials not configured');
            }

            $token = $provider->getAccessToken();
            $provider->setAccessToken($token);

            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route('checkout.paypal.success'),
                    "cancel_url" => route('checkout.paypal.cancel'),
                    "brand_name" => config('app.name'),
                    "user_action" => "PAY_NOW"
                ],
                "purchase_units" => [
                    [
                        "amount" => [
                            "currency_code" => $config['currency'],
                            "value" => number_format($order->total, 2, '.', '')
                        ],
                        "reference_id" => 'order_'.$order->id,
                        "description" => "Order #".$order->id
                    ]
                ]
            ]);

            if (isset($response['error'])) {
                throw new \Exception($response['error']['message'] ?? 'PayPal API error');
            }

            if (isset($response['id']) && $response['id'] != null) {
                foreach ($response['links'] as $link) {
                    if ($link['rel'] === 'approve') {
                        return redirect()->away($link['href']);
                    }
                }
            }

            throw new \Exception('No approval link found in PayPal response');

        } catch (\Exception $e) {
            \Log::error('PayPal Payment Error: '.$e->getMessage());
            return back()
                ->with('error', 'PayPal Error: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    public function paypalSuccess(Request $request)
    {
        try {
            if (!$request->token) {
                throw new \Exception('Payment token missing');
            }

            $provider = new PayPalClient;
            $provider->setApiCredentials(config('services.paypal'));
            $provider->getAccessToken();

            // 1. First check order status
            $orderDetails = $provider->showOrderDetails($request->token);

            if ($orderDetails['status'] !== 'APPROVED') {
                throw new \Exception('Order not approved for capture');
            }

            // 2. Capture payment - CORRECT METHOD NAME
            $response = $provider->capturePaymentOrder($request->token);

            // 3. Verify capture succeeded
            if (!isset($response['status']) || $response['status'] !== 'COMPLETED') {
                throw new \Exception('Capture failed: '.json_encode($response));
            }

            // 4. Process successful payment
            $orderId = str_replace('order_', '', $response['purchase_units'][0]['reference_id']);
            $order = Order::findOrFail($orderId);
            
            $order->update([
                'status' => 'completed',
                'transaction_id' => $response['id']
            ]);
            
            Cart::destroy();
            return redirect()->route('checkout.success')->with('order', $order);

        } catch (\Exception $e) {
            logger()->error('PAYPAL ERROR: '.$e->getMessage());
            return redirect()->route('checkout')
                ->with('error', 'Payment failed: '.$e->getMessage());
        }
    }

    public function paypalCancel()
    {
        return redirect()->route('checkout')->with('error', 'Payment was cancelled');
    }

    public function success()
    {
        if (!session()->has('order')) {
            return redirect()->route('home');
        }

        return view('checkout.success', ['order' => session('order')]);
    }
}