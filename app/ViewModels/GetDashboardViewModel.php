<?php

namespace App\ViewModels;

use App\DataTransferObject\SalesSummaryData;
use App\Services\Gumroad\GumroadService;

class GetDashboardViewModel extends ViewModel
{
    public function __construct(private readonly GumroadService $gumroad)
    {
    }

    public function salesSummary(): SalesSummaryData
    {
        $sales = $this->gumroad->sales();
        $totalRevenue = $sales->sum('price');

        return new SalesSummaryData(
            units_sold: $sales->count(),
            total_revenue: round($totalRevenue, 0),
            average_price: round($totalRevenue / $sales->count(), 1),
        );
    }
}
