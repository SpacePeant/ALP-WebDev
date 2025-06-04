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
        'payment_method',
        'cust_name',
        'cust_phone_number',
        'cust_address',
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

public function getRouteKeyName()
{
    return 'order_id';  // jadi Laravel pakai kolom order_id untuk route model binding
}
}