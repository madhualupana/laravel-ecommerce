<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'address',
        'city',
        'zip',
        'total',
        'payment_method',
        'transaction_id',
        'payment_status',
        'razorpay_order_id',
        'status'
    ];

    protected $casts = [
        'total' => 'decimal:2',
    ];

    // Payment method constants
    const PAYMENT_COD = 'cod';
    const PAYMENT_STRIPE = 'stripe';
    const PAYMENT_PAYPAL = 'paypal';

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the items for the order.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Check if order is paid (not applicable for COD)
     */
    public function isPaid()
    {
        return $this->payment_method !== self::PAYMENT_COD && 
               $this->status === self::STATUS_COMPLETED;
    }

    /**
     * Get formatted order number
     */
    public function getOrderNumberAttribute()
    {
        return 'ORD-' . str_pad($this->id, 8, "0", STR_PAD_LEFT);
    }

    /**
     * Get payment method name
     */
    public function getPaymentMethodNameAttribute()
    {
        return [
            self::PAYMENT_COD => 'Cash on Delivery',
            self::PAYMENT_STRIPE => 'Credit/Debit Card',
            self::PAYMENT_PAYPAL => 'PayPal',
        ][$this->payment_method] ?? $this->payment_method;
    }
}