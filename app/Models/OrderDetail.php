<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_color_id',
        'product_variant_id',
        'quantity',
        'unit_price',
    ];

    // Relasi ke Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relasi ke Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi ke ProductColor
    public function productColor()
    {
        return $this->belongsTo(ProductColor::class);
    }

    // Relasi ke ProductVariant (misal: ukuran)
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
