<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;
use Razorpay\Api\Api;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaymentWebhookController extends Controller
{
    // Stripe Webhook 
    public function handleStripeWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook_secret');
        $event = null;

        try {
            $event = Webhook::constructEvent(
                $payload, $sigHeader, $endpointSecret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            Log::error('Stripe Webhook Error: Invalid payload');
            return response('Invalid payload', 400);
        } catch (SignatureVerificationException $e) {
            // Invalid signature
            Log::error('Stripe Webhook Error: Invalid signature');
            return response('Invalid signature', 400);
        }

        Log::info('Stripe Webhook Received: '.$event->type);

        // Handle the event
        switch ($event->type) {
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object;
                $this->handleStripePaymentSucceeded($paymentIntent);
                break;
                
            case 'payment_intent.payment_failed':
                $paymentIntent = $event->data->object;
                $this->handleStripePaymentFailed($paymentIntent);
                break;
                
            // Add more event types as needed
            default:
                Log::info('Received unhandled Stripe event type: '.$event->type);
        }

        return response('Webhook Handled', 200);
    }

    protected function handleStripePaymentSucceeded($paymentIntent)
    {
        Log::info('Processing Stripe payment_intent.succeeded for ID: '.$paymentIntent->id);
        
        $order = Order::where('transaction_id', $paymentIntent->id)->first();
        
        if ($order) {
            Log::info('Found order #'.$order->id.' with transaction_id '.$order->transaction_id);
            
            $updated = $order->update([
                'status' => 'completed',
                'payment_status' => 'paid'
            ]);
            
            if ($updated) {
                Log::info('Successfully updated order #'.$order->id.' to completed status');
            } else {
                Log::error('Failed to update order #'.$order->id);
            }
        } else {
            Log::error('No order found with transaction_id: '.$paymentIntent->id);
            // Log all orders for debugging (remove after debugging)
            Log::info('All orders with transaction_ids: ', 
                Order::select('id', 'transaction_id')->get()->toArray());
        }
    }

    protected function handleStripePaymentFailed($paymentIntent)
    {
        $order = Order::where('transaction_id', $paymentIntent->id)->first();
        
        if ($order) {
            $order->update([
                'status' => 'failed',
                'payment_status' => 'failed'
            ]);
            
            // You might want to send payment failed notification here
            Log::error('Stripe Payment Failed for Order #'.$order->id);
        }
    }

    // Razorpay Webhook
    public function handleRazorpayWebhook(Request $request)
{
    // Log raw payload for debugging
    Log::info('Raw Razorpay Webhook Payload: '.$request->getContent());
    
    $payload = $request->getContent();
    $webhookSignature = $request->header('X-Razorpay-Signature');
    $webhookSecret = config('services.razorpay.webhook_secret');

    $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

    try {
        $api->utility->verifyWebhookSignature($payload, $webhookSignature, $webhookSecret);
        
        $event = json_decode($payload, true);
        Log::info('Razorpay Webhook Received:', $event);

        switch ($event['event']) {
            case 'payment.captured':
                $this->handleRazorpayPaymentCaptured($event['payload']['payment']['entity']);
                break;
                
            case 'payment.failed':
                $this->handleRazorpayPaymentFailed($event['payload']['payment']['entity']);
                break;
                
            default:
                Log::info('Received unhandled Razorpay event type: '.$event['event']);
        }

        return response('Webhook Handled', 200);
        
    } catch (\Exception $e) {
        Log::error('Razorpay Webhook Error: '.$e->getMessage());
        return response('Invalid signature', 400);
    }
}

protected function handleRazorpayPaymentCaptured($payment)
{
    Log::info('Processing Razorpay payment.captured:', $payment);
    
    // Try to find order by payment ID first
    $order = Order::where('transaction_id', $payment['id'])->first();

    // If not found, try by Razorpay order ID
    if (!$order && isset($payment['order_id'])) {
        $order = Order::where('razorpay_order_id', $payment['order_id'])->first();
    }
    
    if (!$order) {
        Log::error('Razorpay Payment Captured but order not found. Payment ID: '.$payment['id'].' Order ID: '.($payment['order_id'] ?? 'N/A'));
        return;
    }

    $updated = $order->update([
        'status' => 'completed',
        'payment_status' => 'paid'
    ]);
    
    if ($updated) {
        Log::info('Successfully updated order #'.$order->id.' to paid status');
    } else {
        Log::error('Failed to update order #'.$order->id);
    }
}

    protected function handleRazorpayPaymentFailed($payment)
    {
        $order = Order::where('transaction_id', $payment['id'])->first();
        
        if ($order) {
            $order->update([
                'status' => 'failed',
                'payment_status' => 'failed'
            ]);
            
            Log::error('Razorpay Payment Failed for Order #'.$order->id);
        }
    }

    // PayPal Webhook
    public function handlePaypalWebhook(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('services.paypal'));
        $provider->getAccessToken();
        
        $webhookId = config('services.paypal.webhook_id');
        $headers = $request->headers->all();
        $body = $request->getContent();

        try {
            $verify = $provider->verifyWebHook($body, $headers, $webhookId);
            
            if ($verify === 'SUCCESS') {
                $event = json_decode($body, true);
                Log::info('PayPal Webhook Received: '.$event['event_type']);

                switch ($event['event_type']) {
                    case 'PAYMENT.CAPTURE.COMPLETED':
                        $this->handlePaypalPaymentCompleted($event['resource']);
                        break;
                        
                    case 'PAYMENT.CAPTURE.DENIED':
                    case 'PAYMENT.CAPTURE.FAILED':
                        $this->handlePaypalPaymentFailed($event['resource']);
                        break;
                        
                    // Add more event types as needed
                    default:
                        Log::info('Received unhandled PayPal event type: '.$event['event_type']);
                }

                return response('Webhook Handled', 200);
            } else {
                Log::error('PayPal Webhook Verification Failed');
                return response('Verification failed', 400);
            }
        } catch (\Exception $e) {
            Log::error('PayPal Webhook Error: '.$e->getMessage());
            return response('Error processing webhook', 500);
        }
    }

    protected function handlePaypalPaymentCompleted($payment)
    {
        $orderId = str_replace('order_', '', $payment['custom_id'] ?? '');
        $order = Order::find($orderId);
        
        if ($order) {
            $order->update([
                'status' => 'completed',
                'payment_status' => 'paid',
                'transaction_id' => $payment['id']
            ]);
            
            Log::info('PayPal Payment Completed for Order #'.$order->id);
        } else {
            Log::error('PayPal Payment Completed but order not found: '.$orderId);
        }
    }

    protected function handlePaypalPaymentFailed($payment)
    {
        $orderId = str_replace('order_', '', $payment['custom_id'] ?? '');
        $order = Order::find($orderId);
        
        if ($order) {
            $order->update([
                'status' => 'failed',
                'payment_status' => 'failed'
            ]);
            
            Log::error('PayPal Payment Failed for Order #'.$order->id);
        }
    }
}