<?php

namespace App\DataTransferObject;

class ProductData
{
    public function __construct(
        public readonly string $title,
    ) {}
}
