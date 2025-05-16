<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductColorImage extends Model
{
    protected $table = 'product_color_image';

    protected $fillable = [
        'color_id',
        'image_kiri',
        'image_kanan',
        'image_atas',
        'image_bawah',
    ];

    // Relasi ke model ProductColor
    public function productColor()
    {
        return $this->belongsTo(ProductColor::class, 'color_id');
    }
}
