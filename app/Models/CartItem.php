<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $table = 'cart_items';

    protected $fillable = [
        'customer_id',
        'product_id',
        'product_color_id',
        'product_variant_id',
        'quantity',
    ];

    // Relasi ke Customer
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    // CartItem.php
    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function productVariant() {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
    public function productColor() {
        return $this->belongsTo(ProductColor::class, 'product_color_id');
    }

    public function productColorImage()
{
    return $this->hasOneThrough(
        \App\Models\ProductColorImage::class,
        \App\Models\ProductColor::class,
        'color_name', // foreign key on ProductColor
        'color_id',   // foreign key on ProductColorImage
        'color_name', // local key on CartItem
        'id' ,
        'product_color_id'         // local key on ProductColor
    );
}
}

