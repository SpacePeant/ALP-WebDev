<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariant extends Model
{
    //
     use HasFactory;

     public $timestamps = false;

       protected $table = 'product_variant'; // pakai tabel 'product', bukan 'products'

    protected $fillable = [
        'product_id', 'color_id', 'size', 'stock'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function color()
    {
        return $this->belongsTo(ProductColor::class, 'color_id');
    }
}