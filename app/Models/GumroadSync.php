<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GumroadSync extends Model
{
    use HasFactory;

    protected $fillable = [
        'synced_at',
    ];

    protected $casts = [
        'synced_at' => 'datetime'
    ];
}
