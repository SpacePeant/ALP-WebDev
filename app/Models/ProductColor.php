<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductColor extends Model
{
    //
     use HasFactory;

     public $timestamps = false;
     
    protected $table = 'product_color'; // pakai tabel 'product', bukan 'products'
    
    protected $fillable = [
        'product_id', 'color_name', 'color_code', 'is_primary'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'color_id');
    }
}