<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'short_description', 'description', 'price', 
        'compare_price', 'category_id', 'image', 'gallery', 'is_featured', 
        'is_active', 'in_stock', 'quantity', 'rating'
    ];

    protected $casts = [
        'gallery' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'in_stock' => 'boolean',
        'images' => 'array',
        'specifications' => 'array',
    ];

    public function getGalleryUrlsAttribute()
    {
        return collect($this->gallery)->map(function ($image) {
            return asset('storage/'.$image);
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function wishlistedBy()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->compare_price && $this->compare_price > $this->price) {
            return round(100 - ($this->price / $this->compare_price * 100), 0);
        }
        return 0;
    }

    public function getImageUrlAttribute()
    {
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        
        return asset('storage/' . ltrim($this->image, '/'));
    }

    public function scopeSortBy($query, $sortOption)
    {
        if (array_key_exists($sortOption, config('products.sort_options'))) {
            $option = config('products.sort_options')[$sortOption];
            return $query->orderBy($option['field'], $option['direction']);
        }
        return $query;
    }
}