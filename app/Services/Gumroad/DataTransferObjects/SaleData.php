<?php

namespace App\Services\Gumroad\DataTransferObjects;

use App\DataTransferObject\ProductData;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class SaleData
{
    public function __construct(
        public readonly string $email,
        public readonly ?string $full_name,
        public readonly float $price,
        public readonly Carbon $date,
        public readonly ProductData $product,
    ) {}

    public static function make(array $data, Product $product): self
    {
        return new self(
            email: $data['email'],
            full_name: Arr::get($data, 'full_name'),
            price: $data['price'] / 100,
            date: Carbon::parse($data['created_at']),
            product: new ProductData($product->title),
        );
    }
}
