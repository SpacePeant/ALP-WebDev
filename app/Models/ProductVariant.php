<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $table = 'product_variant';

    protected $fillable = [
        'product_id',
        'size',
        'stock',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
