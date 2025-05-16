<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductColor extends Model
{
    protected $table = 'product_color';

        protected $fillable = [
        'product_id', 'color_name', 'color_code', 'is_primary'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function colorImage()
{
    return $this->hasOne(ProductColorImage::class, 'color_id');
}
//
     use HasFactory;

     public $timestamps = false;

    




    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'color_id');
    }
}
