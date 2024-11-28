<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    //

    protected $fillable = [
        'name',
        'slug',
        'price',
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_categories', 'product_id', 'category_id' );
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class,'product_id');
    }

    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }

    public function totalOrder()
    {
        return $this->orderDetails()->sum('quantity');
    }
}
