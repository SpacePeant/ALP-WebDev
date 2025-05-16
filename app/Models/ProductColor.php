<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    protected $table = 'product_color';

    protected $fillable = [
        'product_id',
        'color_code',
        'color_name',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function colorImage()
{
    return $this->hasOne(ProductColorImage::class, 'color_id');
}
}
