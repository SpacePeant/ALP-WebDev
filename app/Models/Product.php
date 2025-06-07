<?php

namespace App\Models;

use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    protected $table = 'product'; // pakai tabel 'product', bukan 'products'

    protected $fillable = [
        'name', 'description', 'price', 'status', 'category_id', 'gender' // tambahkan sesuai field yang ada di tabel
    ];

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function colors()
    {
        return $this->hasMany(ProductColor::class);
    }
    //
     use HasFactory;

    // protected $fillable = [
    //     'name', 'gender', 'description', 'price', 'status', 'category_id'
    // ];



    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getImageUrl($posisi)
    {
        $filename = $this->{'image_' . $posisi};
        $path = "image/sepatu/{$posisi}/" . $filename;

        if (!empty($filename) && File::exists(public_path($path))) {
            return asset($path);
        } else {
            return asset('image/no_image.png');
        }
    }

}

