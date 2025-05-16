<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariant extends Model
{
    protected $table = 'product_variant';

     protected $fillable = [
        'product_id', 'color_id', 'size', 'stock'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
     use HasFactory;

     public $timestamps = false;


    public function color()
    {
        return $this->belongsTo(ProductColor::class, 'color_id');
    }
}
