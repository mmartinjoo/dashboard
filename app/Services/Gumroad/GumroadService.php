<?php

namespace App\Services\Gumroad;

use App\Models\Setting;
use App\Services\Gumroad\DataTransferObjects\SaleData;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class GumroadService
{
    public function __construct(
        private readonly string $accessToken,
        private readonly Setting $setting,
    ) {}

    /**
     * @return Collection<SaleData>
     */
    public function sales(): Collection
    {
        $sales = [];

        foreach ($this->setting->gumroad_product_ids as $productId) {
            $data = Http::get('https://api.gumroad.com/v2/sales', [
                'access_token' => $this->accessToken,
                'product_id' => $productId,
            ])->json('sales');

            $dtos = collect($data)
                ->map(fn (array $sale) => SaleData::fromArray($sale));

            $sales = [
                ...$sales,
                ...$dtos,
            ];
        }

        return collect($sales);
    }
}
