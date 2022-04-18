<?php

namespace App\Services\Gumroad;

use App\Models\Product;
use App\Services\Gumroad\DataTransferObjects\SaleData;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class GumroadService
{
    public function __construct(private readonly string $accessToken)
    {
    }

    /**
     * @return Collection<SaleData>
     */
    public function sales(): Collection
    {
        $sales = [];

        foreach (Product::all() as $product) {
            $salesByProduct = [];

            foreach (range(1, 3) as $page) {
                $response = Http::get('https://api.gumroad.com/v2/sales', [
                    'access_token' => $this->accessToken,
                    'product_id' => $product->gumroad_id,
                    'page' => $page,
                ]);

                $salesByProduct = [
                    ...$salesByProduct,
                    ...$response->json('sales'),
                ];

                if (!$response->json('next_page_url')) {
                    break;
                }
            }

            $dtos = collect($salesByProduct)
                ->map(fn (array $sale) => SaleData::make($sale, $product));

            $sales = [
                ...$sales,
                ...$dtos,
            ];
        }

        return collect($sales);
    }
}
