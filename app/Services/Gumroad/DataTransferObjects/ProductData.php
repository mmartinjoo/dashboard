<?php

namespace App\Services\Gumroad\DataTransferObjects;

class ProductData
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
        );
    }
}
