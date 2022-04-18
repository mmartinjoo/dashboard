<?php

namespace App\Services\Gumroad;

use App\Services\Gumroad\DataTransferObjects\SaleData;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class GumroadService
{
    public function __construct(private readonly string $accessToken)
    {
    }

    // Premium, Plus, Basic
    // DQWTvGKthF55k324P068sQ==, 8gTI5W8mieX4vxvaDki8Tg==, gZpPDEVSkiFyNZ5GQ-ChAQ==
    public function sales(): Collection
    {
        $res = Http::get('https://api.gumroad.com/v2/sales', [
            'access_token' => $this->accessToken,
            'product_id' => 'DQWTvGKthF55k324P068sQ==',
        ]);

        return collect($res->json('sales'))->map(fn (array $sale) => SaleData::fromArray($sale));
    }
}
