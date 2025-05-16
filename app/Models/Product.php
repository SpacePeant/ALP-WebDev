<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    //
     use HasFactory;

    // protected $fillable = [
    //     'name', 'gender', 'description', 'price', 'status', 'category_id'
    // ];

    protected $table = 'product'; // pakai tabel 'product', bukan 'products'

    protected $fillable = [
        'name', 'description', 'price', 'status', 'category_id', 'gender' // tambahkan sesuai field yang ada di tabel
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function colors()
    {
        return $this->hasMany(ProductColor::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}