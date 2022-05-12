<?php

namespace App\ViewModels;

use App\DataTransferObject\ProductData;
use App\DataTransferObject\ProductSaleSummaryData;
use App\DataTransferObject\SaleData;
use App\DataTransferObject\SalesSummaryData;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Collection;

class GetDashboardViewModel extends ViewModel
{
    /**
     * @var Collection<Sale>
     */
    private Collection $sales;

    public function __construct(private readonly Collection $products)
    {
        $this->sales = Sale::latest('sold_at')
            ->whereIn('product_id', $this->products->pluck('id'))
            ->get();
    }

    /**
     * @return Collection<SaleData>
     */
    public function sales(): Collection
    {
        return $this->sales->take(10)->map(fn (Sale $sale) => SaleData::fromModel($sale));
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

        return $this->products->map(function (Product $product) use ($totalRevenue) {
            $productRevenue = $product->sales->sum('revenue');

            return new ProductSaleSummaryData(
                product: ProductData::fromModel($product),
                total_revenue: $productRevenue,
                units_sold: $product->sales->count(),
                total_revenue_contribution: $productRevenue / $totalRevenue,
            );
        });
    }

    private function totalRevenue(): float
    {
        return $this->sales->sum('revenue');
    }
}
