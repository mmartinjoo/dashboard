<?php

namespace App\Services\Gumroad;

use App\Models\Product;
use App\Services\Gumroad\DataTransferObjects\SaleData;
use Carbon\Carbon;
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
    public function sales(?Carbon $after = null): Collection
    {
        $sales = [];

        foreach (Product::all() as $product) {
            $salesByProduct = [];

            foreach (range(1, 3) as $page) {
                $requestData = [
                    'access_token' => $this->accessToken,
                    'product_id' => $product->gumroad_id,
                    'page' => $page
                ];

                if ($after) {
                    $requestData['after'] = $after->format('Y-m-d');
                }

                $response = Http::get('https://api.gumroad.com/v2/sales', $requestData);

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

        return collect($sales)->sortByDesc('date');
    }

    public function products(): Collection
    {
        $products = Http::get('https://api.gumroad.com/v2/products', [
            'access_token' => $this->accessToken,
        ])->json('products');

        return collect($products);
    }
}
