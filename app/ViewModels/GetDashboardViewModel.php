<?php

namespace App\ViewModels;

use App\DataTransferObject\ProductData;
use App\DataTransferObject\ProductSaleSummaryData;
use App\DataTransferObject\SalesSummaryData;
use App\Models\Product;
use App\Services\Gumroad\DataTransferObjects\SaleData;
use App\Services\Gumroad\GumroadService;
use Illuminate\Support\Collection;

class GetDashboardViewModel extends ViewModel
{
    /**
     * @var Collection<SaleData>
     */
    private Collection $sales;

    public function __construct(private readonly GumroadService $gumroad)
    {
        $this->sales = $this->gumroad->sales();
    }

    public function sales(): Collection
    {
        return $this->sales->sortByDesc('date');
    }

    public function salesSummary(): SalesSummaryData
    {
        $totalRevenue = $this->totalRevenue();

        return new SalesSummaryData(
            units_sold: $this->sales->count(),
            total_revenue: round($totalRevenue, 0),
            average_price: round($totalRevenue / $this->sales->count(), 1),
        );
    }

    /**
     * @return Collection<ProductSaleSummaryData>
     */
    public function productSummaries(): Collection
    {
        $totalRevenue = $this->totalRevenue();

        return Product::all()->map(function (Product $product) use ($totalRevenue) {
            $sales = $this->sales->filter(fn (SaleData $data) =>
                $data->product->gumroad_id === $product->gumroad_id
            );

            $productRevenue = $sales->sum('price');

            return new ProductSaleSummaryData(
                product: ProductData::fromModel($product),
                total_revenue: $productRevenue,
                units_sold: $sales->count(),
                total_revenue_contribution: $productRevenue / $totalRevenue,
            );
        });
    }

    private function totalRevenue(): float
    {
        return $this->sales->sum('price');
    }
}
