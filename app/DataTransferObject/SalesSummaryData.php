<?php

namespace App\DataTransferObject;

class SalesSummaryData
{
    public function __construct(
        public readonly int $units_sold,
        public readonly float $total_revenue,
        public readonly float $average_price,
    ) {}
}
