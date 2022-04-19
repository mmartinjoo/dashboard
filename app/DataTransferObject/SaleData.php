<?php

namespace App\DataTransferObject;

use App\Models\Sale;
use Carbon\Carbon;

class SaleData
{
    public function __construct(
        public readonly string $customer_email,
        public readonly ?string $customer_name,
        public readonly float $price,
        public readonly Carbon $sold_at,
        public readonly ProductData $product,
    ) {}

    public static function fromModel(Sale $sale): self
    {
        return new self(
            customer_email: $sale->customer_email,
            customer_name: $sale->customer_email,
            price: $sale->price,
            sold_at: $sale->sold_at,
            product: ProductData::fromModel($sale->product),
        );
    }
}
