<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    protected $fillable = [
    'product_id',
    'user_id',
    'rating',
    'review_title',
    'comment',
    'review_date',
    'created_at',
    'updated_at'
];

    public function user()
{
    return $this->belongsTo(User::class);
}

}
