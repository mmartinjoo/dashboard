<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'gumroad_id',
        'title',
    ];

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }
}
