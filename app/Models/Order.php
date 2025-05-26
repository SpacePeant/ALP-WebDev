<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_date',
        'status',
        'total_amount',
        'payment_method'
    ];

    // Relasi ke Customer
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke OrderDetail
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function details()
{
    return $this->hasMany(\App\Models\OrderDetail::class, 'order_id');
}
}