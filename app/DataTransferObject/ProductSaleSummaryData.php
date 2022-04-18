<?php

namespace App\DataTransferObject;

class ProductSaleSummaryData
{
    public function __construct(
        public readonly ProductData $product,
        public readonly float $total_revenue,
        public readonly int $units_sold,
        public readonly float $total_revenue_contribution,
    ) {}
}
