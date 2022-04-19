<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'customer_email',
        'customer_name',
        'price',
        'sold_at',
    ];

    protected $casts = [
        'sold_at' => 'datetime',
    ];
}
