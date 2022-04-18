<?php

namespace App\DataTransferObject;

use App\Models\Product;

class ProductData
{
    public function __construct(
        public readonly string $gumroad_id,
        public readonly string $title,
    ) {}

    public static function fromModel(Product $product): self
    {
        return new self(
            gumroad_id: $product->gumroad_id,
            title: $product->title,
        );
    }
}
