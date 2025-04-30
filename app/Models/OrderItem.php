<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'price',
        'quantity',
        'options'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'options' => 'array',
    ];

    /**
     * Get the order that owns the order item.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product that owns the order item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Calculate total price for this item
     */
    public function getTotalAttribute()
    {
        return $this->price * $this->quantity;
    }

    /**
     * Get formatted options
     */
    public function getFormattedOptionsAttribute()
    {
        if (empty($this->options)) {
            return null;
        }

        $options = [];
        foreach ($this->options as $key => $value) {
            $options[] = ucfirst($key) . ': ' . $value;
        }

        return implode(', ', $options);
    }
}