<?php

namespace App\Services\Gumroad;

use App\Models\Product;
use App\Services\Gumroad\DataTransferObjects\ProductData;
use App\Services\Gumroad\DataTransferObjects\SaleData;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class GumroadService
{
    public function __construct(
        private readonly string $accessToken,
        private readonly string $uri,
    ) {}

    /**
     * @param Collection<Product> $products
     * @param Carbon|null $after
     * @return Collection<SaleData>
     */
    public function sales(Collection $products, ?Carbon $after = null): Collection
    {
        $sales = [];

        foreach ($products as $product) {
            $salesByProduct = [];

            for ($page = 1; ; $page++) {
                $requestData = [
                    'access_token' => $this->accessToken,
                    'product_id' => $product->gumroad_id,
                    'page' => $page
                ];

                if ($after) {
                    $requestData['after'] = $after->format('Y-m-d');
                }

                $response = Http::get("{$this->uri}/sales", $requestData);

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

    /**
     * @return Collection<ProductData>
     */
    public function products(): Collection
    {
        $products = Http::get("{$this->uri}/products", [
            'access_token' => $this->accessToken,
        ])->json('products');

        return collect($products)->map(fn (array $data) => ProductData::fromArray($data));
    }
}
