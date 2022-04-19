<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sale extends Model
{
    use HasFactory;

    protected $with = ['product'];

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

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
