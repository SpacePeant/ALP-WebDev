<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'users';

    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    //     'address',
    //     'phone_number',
    //     'registration_date',
    //     'remember_token',
    //     'created_at',
    //     'updated_at'
    // ];

    protected $fillable = [
        'name', 'address', 'email', 'phone_number', 'password', 'registration_date', 'remember_token',
    ];
    
    protected $hidden = ['password', 'remember_token'];
}
