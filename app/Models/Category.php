<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    // protected $fillable = ['name'];

    // public function products()
    // {
    //     return $this->hasMany(Product::class);
    // }
    public $timestamps = false;
    
    protected $table = 'category'; // nama tabel sesuai di DB

    protected $fillable = ['name']; // kolom yang bisa diisi massal
}